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
use Here\Lib\Env\GlobalEnvironment;
use Here\Lib\Env\UserEnvironment;
use Here\Lib\Exceptions\Internal\ImpossibleError;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComplexComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\CompositeComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\FullMatchComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\OptionalComplexComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ScalarComponentInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\VariableComplexComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrl;


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
     * ChannelTrie constructor.
     */
    final public function __construct() {
        $this->_tree = array();
    }

    /**
     * @param RouterChannel $channel
     * @throws ImpossibleError
     */
    final public function tree_parse(RouterChannel $channel): void {
        /* @var AddUrl $url_component */
        $url_component = $channel->get_url_component();

        /* @var ValidUrl $valid_url */
        foreach ($url_component as $valid_url) {
            // insert routing
            $this->_insert_node($valid_url, $channel);
        }
    }

    /**
     * @param ValidUrl $valid_url
     * @param RouterChannel $channel
     * @throws ImpossibleError
     */
    final private function _insert_node(ValidUrl &$valid_url, RouterChannel &$channel): void {
        // root-path
        if (count($valid_url) === 1) {
            if ($this->_parse_root_path($valid_url)) {
                $this->_tree[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] = $channel;
                return;
            }
        }

        // loop-insert
        $position = &$this->_tree;

        /* @var ComponentInterface $component */
        foreach ($valid_url as $component) {
            $node_type = null;
            switch (true) {
                case ($component instanceof ScalarComponentInterface):
                    $this->_insert_scalar_node($position, $component); break;
                case ($component instanceof ComplexComponentInterface):
                    $this->_insert_complex_node($position, $component); break;
                case ($component instanceof CompositeComponentInterface):
                    $node_type = TreeNodeType::NODE_TYPE_COMPOSITE_PATH; break;
                case ($component instanceof FullMatchComponentInterface):
                    $node_type = TreeNodeType::NODE_TYPE_FULL_MATCH_PATH; break;
                default:
                    throw new ImpossibleError("what type of component?");
            }
        }

        $position[TreeNodeType::NODE_TYPE_MATCHED_CHANNEL] = $channel;
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
     * @param array $position
     * @param ScalarComponentInterface $component
     */
    final private function _insert_scalar_node(array &$position, ScalarComponentInterface $component): void {
        if (!isset($position[TreeNodeType::NODE_TYPE_SCALAR_PATH])) {
            $position[TreeNodeType::NODE_TYPE_SCALAR_PATH] = array();
        }

        // switch to next layout
        $position = &$position[TreeNodeType::NODE_TYPE_SCALAR_PATH];

        // parse `scalar string`
        preg_match('/\^(?<scalar_string>.*)\$/', $component->get_regex()->get_pattern(), $matches);
        $scalar_string = $matches['scalar_string'];
        if (!isset($position[$scalar_string])) {
            $position[$scalar_string] = array();
        }
        $position = &$position[$matches['scalar_string']];
    }

    /**
     * @param array $position
     * @param ComplexComponentInterface $component
     */
    final private function _insert_complex_node(array &$position, ComplexComponentInterface $component): void {
        $node_type = TreeNodeType::NODE_TYPE_VAR_COMPLEX_PATH;
        if ($component instanceof OptionalComplexComponent) {
            $node_type = TreeNodeType::NODE_TYPE_OPT_COMPLEX_PATH;
        }

        if (!isset($position[$node_type])) {
            $position[$node_type] = array();
        }

        // switch to next layout
        $position = &$position[$node_type];

        // insert regex
        $position[$component->get_regex()->get_pattern()] = array();
        $position = &$position[$component->get_regex()->get_pattern()];
    }
}
