<?php
/**
 * Singleton.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Singleton;


trait SingletonPattern {
    /**
     * @var self
     */
    private static $_instance;

    /**
     * @throws SingletonRefuse
     */
    final public function __clone() {
        throw new SingletonRefuse('singleton cannot clone');
    }

    /**
     * @return self
     * @throws SingletonRefuse
     */
    final public static function get_instance() {
        if (self::$_instance === null) {
            throw new SingletonRefuse('singleton has not initializing');
        }
        return self::$_instance;
    }

    /**
     * @param self $self
     * @throws SingletonRefuse
     */
    final protected static function set_instance($self) {
        if (get_class($self) !== __CLASS__) {
            throw new SingletonRefuse('instance invalid of self');
        }

        if (self::$_instance !== null) {
            throw new SingletonRefuse('cannot set instance second');
        }

        self::$_instance = $self;
    }
}
