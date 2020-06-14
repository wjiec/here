<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Field;


/**
 * Class Cleaner
 *
 * @package Here\Library\Field
 */
class Cleaner {

    /**
     * remove key from memory
     *
     * @param string $key
     */
    public static function fromMemory(string $key) {
        container('field.memory')->del($key);
    }

    /**
     * remove key from cache
     *
     * @param string $key
     */
    public static function fromCache(string $key) {
        container('field.cache')->del($key);
    }

    /**
     * remove key from database
     *
     * @param string $key
     */
    public static function fromDb(string $key) {
        container('field.db')->del($key);
    }

    /**
     * remove key from composition stores
     *
     * @param string $key
     */
    public static function fromAll(string $key) {
        container('field')->del($key);
    }

}
