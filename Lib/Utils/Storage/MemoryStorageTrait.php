<?php
/**
 * MemoryStorageTrait.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Storage;
use Here\Lib\Extension\Callback\CallbackObject;


/**
 * Trait MemoryStorageTrait
 * @package Lib\Utils\Storage
 */
trait MemoryStorageTrait {
    /**
     * @var array
     */
    private static $_storage = array();

    /**
     * @param string $name
     * @param null $default
     * @return null|mixed
     */
    final protected static function get_persistent(string $name, $default = null) {
        return static::$_storage[$name] ?? $default;
    }

    /**
     * @param string $name
     * @param $value
     */
    final protected static function set_persistent(string $name, $value) {
        static::$_storage[$name] = $value;
    }

    /**
     * @param CallbackObject $callback
     * @param null $default
     * @return mixed|null
     * @throws \ArgumentCountError
     */
    final protected static function forEach(CallbackObject $callback, $default = null) {
        foreach (static::$_storage as $path => $config) {
            $ret = $callback->apply($config, $path);
            if ($ret) {
                return $ret;
            }
        }
        return $default;
    }
}
