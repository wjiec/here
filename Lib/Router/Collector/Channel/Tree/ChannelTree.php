<?php
/**
 * ChannelTrie.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel\Tree;
use Here\Config\Constant\SysConstant;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Exceptions\Internal\ImpossibleError;
use Here\Lib\Extension\Regex\Regex;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\VariableCompositeComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComplexComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\CompositeComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\FullMatchComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\OptionalComplexComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ScalarComponentInterface;
use Here\Lib\Router\RouterRequest;


/**
 * Class ChannelTrie
 * @package Here\Lib\Router\Collector\Channel\Trie
 */
final class ChannelTree {
    /**
     * @var array
     */
    private $_tree;

    /**
     * @var &array
     */
    private $_position;

    /**
     * @var string
     */
    private static $_anonymous_name;

    /**
     * ChannelTrie constructor.
     */
    final public function __construct() {
        // initializing anonymous name
        self::$_anonymous_name = '';

        $this->_tree = array();
        $this->_position = &$this->_tree;
    }

    /**
     * @param RouterChannel $channel
     * @throws ImpossibleError
     */
    final public function tree_parse(RouterChannel &$channel): void {
        /* @var AddUrl $add_url */
        $add_url = $channel->get_url_component();

        /* @var ValidUrl $valid_url */
        foreach ($add_url as $valid_url) {
            $this->_position = &$this->_tree;
            $this->insert_node($valid_url, $channel);
        }
    }

    /**
     * @param string $request_uri
     * @return RouterChannel|null
     */
    final public function find_channel(string $request_uri): ?RouterChannel {
        $segments = array_filter(
            explode(SysConstant::URL_SEPARATOR, $request_uri),
            function($segment): bool {
                return strlen($segment);
            }
        );

        // recursion find channel
        return $this->recursion_find($this->_tree, $segments);
    }

    /**
     * @param array $tree
     * @param array $segments
     * @return RouterChannel|null
     */
    final private function recursion_find(array &$tree, array $segments): ?RouterChannel {
        // first check segments is empty
        if (empty($segments)) {
            return $tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] ?? null;
        }

        $current_segment = array_shift($segments);

        // second, check `scalar-node`
        if (isset($tree[TreeNodeType::NODE_TYPE_SCALAR_PATH])) {
            foreach ($tree[TreeNodeType::NODE_TYPE_SCALAR_PATH] as $_scalar => &$_scalar_tree) {
                // from user environment getting or using scalar value
                if ($_scalar[0] === '&') {
                    $_scalar_name = substr($_scalar, 1);
                    $_scalar = GlobalEnvironment::get_user_env($_scalar_name, $_scalar_name);
                }

                // scalar matched
                if ($_scalar === $current_segment) {
                    $channel = $this->recursion_find($_scalar_tree, $segments);
                    if ($channel instanceof RouterChannel) {
                        // found channel
                        return $channel;
                    }
                }
            }
            unset($_scalar_tree);
        }

        // third, check `composite-node`
        if (isset($tree[TreeNodeType::NODE_TYPE_COMPOSITE_PATH])) {
            foreach ($tree[TreeNodeType::NODE_TYPE_COMPOSITE_PATH] as $_pattern => &$_composite_tree) {
                $regex = new Regex($_pattern);
                if (($result = $regex->match($current_segment))) {
                    $name = self::find_named_key($result);
                    RouterRequest::push_router_pair($name, $result[$name]);

                    $channel = $this->recursion_find($_composite_tree, $segments);
                    if ($channel instanceof RouterChannel) {
                        return $channel;
                    } else {
                        RouterRequest::delete_router_pair($name);
                    }
                }
            }
            unset($_composite_tree);
        }

        // fourth, check `variable-node`, the same to `composite-node`
        if (isset($tree[TreeNodeType::NODE_TYPE_VAR_COMPLEX_PATH])) {
            foreach ($tree[TreeNodeType::NODE_TYPE_VAR_COMPLEX_PATH] as $_pattern => &$_var_tree) {
                $regex = new Regex($_pattern);
                if (($result = $regex->match($current_segment))) {
                    $name = self::find_named_key($result);
                    RouterRequest::push_router_pair($name, $result[$name]);

                    $channel = $this->recursion_find($_var_tree, $segments);
                    if ($channel instanceof RouterChannel) {
                        return $channel;
                    } else {
                        RouterRequest::delete_router_pair($name);
                    }
                }
            }
            unset($_var_tree);
        }

        // fifth, check `optional-node`, must be ending of route
        if (empty($segments) && isset($tree[TreeNodeType::NODE_TYPE_OPT_COMPLEX_PATH])) {
            foreach ($tree[TreeNodeType::NODE_TYPE_OPT_COMPLEX_PATH] as $_pattern => &$_opt_tree) {
                $regex = new Regex($_pattern);
                if (($result = $regex->match($current_segment))) {
                    $name = self::find_named_key($result);
                    RouterRequest::push_router_pair($name, $result[$name]);

                    $channel = $_opt_tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] ?? null;
                    if ($channel instanceof RouterChannel) {
                        return $channel;
                    } else {
                        RouterRequest::delete_router_pair($name);
                    }
                }
            }
            unset($_opt_tree);
        }

        // last check `full-match-node`
        if (isset($tree[TreeNodeType::NODE_TYPE_FULL_MATCH_PATH])) {
            foreach ($tree[TreeNodeType::NODE_TYPE_FULL_MATCH_PATH] as $_pattern => &$_full_match_tree) {
                list($name, $attributes) = explode('@', $_pattern, 2);

                $complete_segments = array_merge(array($current_segment), $segments);
                RouterRequest::push_router_pair($name, join(SysConstant::URL_SEPARATOR, $complete_segments));

                if ($this->check_attributes($complete_segments, $attributes)) {
                    $channel = $_full_match_tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] ?? null;
                    if ($channel instanceof RouterChannel) {
                        return $channel;
                    } else {
                        RouterRequest::delete_router_pair($name);
                    }
                }
            }
            unset($_full_match_tree);
        }

        return null;
    }

    /**
     * @param array $segments
     * @param string $attributes
     * @return bool
     */
    final private function check_attributes(array $segments, string $attributes): bool {
        // empty attributes
        if ($attributes === '') {
            return true;
        }

        if (preg_match_all('/[A-Z]\d?/m', $attributes, $matches)) {
            foreach ($matches[0] as $match_item) {
                switch ($match_item[0]) {
                    case 'R':  // required flag
                        if (empty($segments)) {
                            return false;
                        }
                        break;
                    case 'S':  // segments limit
                        if (count($segments) < intval($match_item[1])) {
                            return false;
                        }
                        break;
                }
            }
        }

        return true;
    }

    /**
     * @param ValidUrl $valid_url
     * @param RouterChannel $channel
     * @throws ImpossibleError
     */
    final private function insert_node(ValidUrl &$valid_url, RouterChannel &$channel): void {
        if (count($valid_url) === 1) {
            if ($this->parse_root_path($valid_url)) {
                $this->_tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] = $channel;
                return;
            }
        }

        /* @var ComponentInterface $component */
        foreach ($valid_url as $component) {
            $node_type = null;
            switch (true) {
                case ($component instanceof ScalarComponentInterface):
                    $this->insert_scalar_node($component); break;
                case ($component instanceof ComplexComponentInterface):
                    $this->insert_complex_node($component); break;
                case ($component instanceof CompositeComponentInterface):
                    $this->insert_composite_node($component); break;
                case ($component instanceof FullMatchComponentInterface):
                    $this->insert_full_match_node($component); break;
                default:
                    throw new ImpossibleError("what type of component?");
            }
        }

        $this->_position[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] = $channel;
    }

    /**
     * @param ValidUrl $valid_url
     * @return bool
     */
    final private function parse_root_path(ValidUrl $valid_url): bool {
        $first_component = $valid_url->glimpse_last();

        // is scalar component
        if ($first_component instanceof ScalarComponentInterface) {
            // try match empty path
            if ($first_component->get_regex()->match('')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param ScalarComponentInterface $component
     */
    final private function insert_scalar_node(ScalarComponentInterface $component): void {
        if (!isset($this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH])) {
            $this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH] = array();
        }
        // switch to next layout
        $this->_position = &$this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH];

        $scalar_string = self::trim_pattern_wrapper($component->get_regex()->get_pattern());
        if (!isset($this->_position[$scalar_string])) {
            $this->_position[$scalar_string] = array();
        }
        $this->_position = &$this->_position[$scalar_string];
    }

    /**
     * @param ComplexComponentInterface $component
     */
    final private function insert_complex_node(ComplexComponentInterface $component): void {
        $node_type = TreeNodeType::NODE_TYPE_VAR_COMPLEX_PATH;
        if ($component instanceof OptionalComplexComponent) {
            $node_type = TreeNodeType::NODE_TYPE_OPT_COMPLEX_PATH;
        }

        if (!isset($this->_position[$node_type])) {
            $this->_position[$node_type] = array();
        }
        // switch to next layout
        $this->_position = &$this->_position[$node_type];

        $trimmed_pattern = self::trim_pattern_wrapper($component->get_regex()->get_pattern());
        $complete_pattern = self::make_named_pattern($component->get_name(), $trimmed_pattern);
        if (!isset($this->_position[$complete_pattern])) {
            $this->_position[$complete_pattern] = array();
        }
        $this->_position = &$this->_position[$complete_pattern];
    }

    /**
     * @param CompositeComponentInterface $component
     */
    final private function insert_composite_node(CompositeComponentInterface $component): void {
        if (!isset($this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH])) {
            $this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH] = array();
        }
        $this->_position = &$this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH];

        $trimmed_pattern = self::trim_pattern_wrapper($component->get_regex()->get_pattern());
        $complete_pattern = self::make_composite_pattern(
            ($component instanceof VariableCompositeComponent),
            $component->get_name(), $component->get_scalar(), $trimmed_pattern);

        if (!isset($this->_position[$complete_pattern])) {
            $this->_position[$complete_pattern] = array();
        }
        $this->_position = &$this->_position[$complete_pattern];
    }

    /**
     * @param FullMatchComponentInterface $component
     */
    final private function insert_full_match_node(FullMatchComponentInterface $component): void {
        if (!isset($this->_position[TreeNodeType::NODE_TYPE_FULL_MATCH_PATH])) {
            $this->_position[TreeNodeType::NODE_TYPE_FULL_MATCH_PATH] = array();
        }
        $this->_position = &$this->_position[TreeNodeType::NODE_TYPE_FULL_MATCH_PATH];

        $complete_key = sprintf('%s@%s', $component->get_name(), $component->get_attributes());
        if (!isset($this->_position[$complete_key])) {
            $this->_position[$complete_key] = array();
        }
        $this->_position = &$this->_position[$complete_key];
    }

    /**
     * @param string $name
     * @param string $pattern
     * @return string
     */
    final private static function make_named_pattern(string $name, string $pattern): string {
        return sprintf('/^(?<%s>%s)$/', $name, $pattern);
    }

    /**
     * @param bool $is_require
     * @param null|string $name
     * @param string $scalar
     * @param string $pattern
     * @return string
     */
    final private static function make_composite_pattern(bool $is_require, ?string $name,
                                                         string $scalar, string $pattern): string {
        self::$_anonymous_name .= '_';
        return sprintf('/^%s(?<%s>%s)%s$/',
            $scalar, $name ?? self::$_anonymous_name, $pattern, $is_require ? '' : '?');
    }

    /**
     * @param string $pattern
     * @return string
     */
    final private static function trim_pattern_wrapper(string $pattern): string {
        // trim `/^` and `$/`
        return substr($pattern, 2, strlen($pattern) - 4);
    }

    /**
     * @param array $matches
     * @return string|null
     */
    final private static function find_named_key(array &$matches): ?string {
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                return $key;
            }
        }
        return $matches[0] ?? 0;
    }
}
