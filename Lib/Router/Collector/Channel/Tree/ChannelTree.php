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
use Here\Lib\Exceptions\Internal\ImpossibleError;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComplexComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\CompositeComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\FullMatchComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\OptionalComplexComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ScalarComponentInterface;


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
     * @throws \Here\Lib\Router\Collector\MetaComponentNotFound
     */
    final public function tree_parse(RouterChannel &$channel): void {
        /* @var AddUrl $add_url */
        $add_url = $channel->get_url_component();

        /* @var ValidUrl $valid_url */
        foreach ($add_url as $valid_url) {
            $this->_position = &$this->_tree;
            $this->_insert_node($valid_url, $channel);
        }
    }

    /**
     * @param ValidUrl $valid_url
     * @param RouterChannel $channel
     * @throws ImpossibleError
     */
    final private function _insert_node(ValidUrl &$valid_url, RouterChannel &$channel): void {
        if (count($valid_url) === 1) {
            if ($this->_parse_root_path($valid_url)) {
                $this->_tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] = $channel;
                return;
            }
        }

        /* @var ComponentInterface $component */
        foreach ($valid_url as $component) {
            $node_type = null;
            switch (true) {
                case ($component instanceof ScalarComponentInterface):
                    $this->_insert_scalar_node($component); break;
                case ($component instanceof ComplexComponentInterface):
                    $this->_insert_complex_node($component); break;
                case ($component instanceof CompositeComponentInterface):
                    $this->_insert_composite_node($component); break;
                case ($component instanceof FullMatchComponentInterface): break;
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
    final private function _parse_root_path(ValidUrl $valid_url): bool {
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
    final private function _insert_scalar_node(ScalarComponentInterface $component): void {
        if (!isset($this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH])) {
            $this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH] = array();
        }
        // switch to next layout
        $this->_position = &$this->_position[TreeNodeType::NODE_TYPE_SCALAR_PATH];

        $scalar_string = self::_trim_pattern_wrapper($component->get_regex()->get_pattern());
        if (!isset($this->_position[$scalar_string])) {
            $this->_position[$scalar_string] = array();
        }
        $this->_position = &$this->_position[$scalar_string];
    }

    /**
     * @param ComplexComponentInterface $component
     */
    final private function _insert_complex_node(ComplexComponentInterface $component): void {
        $node_type = TreeNodeType::NODE_TYPE_VAR_COMPLEX_PATH;
        if ($component instanceof OptionalComplexComponent) {
            $node_type = TreeNodeType::NODE_TYPE_OPT_COMPLEX_PATH;
        }

        if (!isset($this->_position[$node_type])) {
            $this->_position[$node_type] = array();
        }
        // switch to next layout
        $this->_position = &$this->_position[$node_type];

        $trimmed_pattern = self::_trim_pattern_wrapper($component->get_regex()->get_pattern());
        $complete_pattern = self::_make_named_pattern($component->get_name(), $trimmed_pattern);
        if (!isset($this->_position[$complete_pattern])) {
            $this->_position[$complete_pattern] = array();
        }
        $this->_position = &$this->_position[$complete_pattern];
    }

    /**
     * @param CompositeComponentInterface $component
     */
    final private function _insert_composite_node(CompositeComponentInterface $component): void {
        if (!isset($this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH])) {
            $this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH] = array();
        }
        $this->_position = &$this->_position[TreeNodeType::NODE_TYPE_COMPOSITE_PATH];

        $trimmed_pattern = self::_trim_pattern_wrapper($component->get_regex()->get_pattern());
        $complete_pattern = self::_make_composite_pattern(
            $component->get_name(), $component->get_scalar(), $trimmed_pattern);

        if (!isset($this->_position[$complete_pattern])) {
            $this->_position[$complete_pattern] = array();
        }
        $this->_position = &$this->_position[$complete_pattern];
    }

    /**
     * @param string $name
     * @param string $pattern
     * @return string
     */
    final private static function _make_named_pattern(string $name, string $pattern): string {
        return sprintf('/^(?<%s>%s)$/', $name, $pattern);
    }

    /**
     * @param null|string $name
     * @param string $scalar
     * @param string $pattern
     * @return string
     */
    final private static function _make_composite_pattern(?string $name, string $scalar, string $pattern): string {
        self::$_anonymous_name .= '_';
        return sprintf('/^%s(?<%s>%s)?$/', $scalar, $name ?? self::$_anonymous_name, $pattern);
    }

    /**
     * @param string $pattern
     * @return string
     */
    final private static function _trim_pattern_wrapper(string $pattern): string {
        // trim `/^` and `$/`
        return substr($pattern, 2, strlen($pattern) - 4);
    }
}
