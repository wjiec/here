<?php
/**
 * Here Plugin Base Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Abstracts_Plugin
 */
abstract class Here_Abstracts_Plugin {
    /**
     * plugin name
     *
     * @var string
     */
    protected $_plugin_name;

    /**
     * plugin owned options
     *
     * @var array
     */
    protected $_plugin_options;

    /**
     * Here_Abstracts_Plugin constructor.
     *
     * @param array $options
     */
    final public function __construct(array $options = array()) {
    }
}