<?php
/**
 * Autoloader.php
 *
 * @package   Here\Lib
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib;


/**
 * Class Autoloader
 * @package Here\Lib
 */
final class Autoloader {
    /**
     * @var self
     */
    private static $_loader;

    /**
     * @var string
     */
    private $_root_path;

    /**
     * @var array<string, string>
     */
    private $_namespace_pool;

    /**
     * Autoloader constructor.
     */
    final public function __construct() {
        $this->_namespace_pool = array();
    }

    /**
     * @param string $class_name
     */
    final private function _loader($class_name) {
    }

    /**
     * @param string $namespace
     * @param string $path
     */
    final private function _register($namespace, $path) {
    }

    /**
     * loader for classes
     *
     * @param string $class_name
     */
    final static public function loader($class_name) {
        if (self::$_loader === null) {
            self::$_loader = new self();
        }
        self::$_loader->_loader($class_name);
    }

    /**
     * @param string $root
     */
    final static public function set_root($root) {
        if (self::$_loader === null) {
            self::$_loader = new self();
        }
        self::$_loader->_root_path = $root;
    }

    /**
     * register a namespace to real path
     *
     * @param string $namespace
     * @param string $path
     */
    final static public function register($namespace, $path) {
        if (self::$_loader === null) {
            self::$_loader = new self();
        }
        self::$_loader->_register($namespace, $path);
    }

    /**
     * check class file exists
     *
     * @param string $class_name
     * @return bool
     */
    final static public function class_exists($class_name) {
        return true;
    }
}
