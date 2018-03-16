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
    final protected static function _get_persistent(string $name, $default = null) {
        return static::$_storage[$name] ?? $default;
    }

    /**
     * @param string $name
     * @param $value
     */
    final protected static function _set_persistent(string $name, $value) {
        static::$_storage[$name] = $value;
    }
}
