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
namespace Here\Lib\Loader;


/**
 * Class Autoloader
 * @package Here\Lib
 */
final class Autoloader {
    /**
     * @var array
     */
    private static $_prefixes = array();

    /**
     * @var bool
     */
    private static $_already_registered = false;

    /**
     * @param string $namespace
     * @param string $base_dir
     * @param bool $prepend
     */
    final public static function add_namespace(string $namespace, string $base_dir, bool $prepend = false): void {
        if (!self::$_already_registered) {
            // register auto loader for classes
            spl_autoload_register(array('self', 'load_class'));
            self::$_already_registered = true;
        }

        $namespace = trim($namespace, '\\') . '\\';
        $base_dir = rtrim(str_replace('\\', '/', $base_dir), '/') . '/';

        if (!isset(self::$_prefixes[$namespace])) {
            self::$_prefixes[$namespace] = array();
        }

        if ($prepend) {
            array_unshift(self::$_prefixes[$namespace], $base_dir);
        } else {
            self::$_prefixes[$namespace][] = $base_dir;
        }
    }

    /**
     * @param string $class_name
     * @param bool $just_check
     * @return bool
     */
    final public static function load_class(string $class_name, bool $just_check = false): bool {
        $prefix = $class_name;

        while (($pos = strrpos($prefix, '\\')) !== false) {
            $prefix = substr($prefix, 0, $pos + 1);
            $class = substr($class_name, $pos + 1);

            if (self::load_mapped_file($prefix, $class, $just_check)) {
                // we're found
                return true;
            }

            $prefix = rtrim($prefix, '\\');
        }

        // not found
        return false;
    }

    /**
     * @param string $class_name
     * @return bool
     */
    final public static function class_exists(string $class_name): bool {
        return self::load_class($class_name, true);
    }

    /**
     * @param string $namespace
     * @param string $class
     * @param bool $just_check
     * @return bool
     */
    final private static function load_mapped_file(string $namespace, string $class, bool $just_check): bool {
        if (!isset(self::$_prefixes[$namespace])) {
            return false;
        }

        foreach (self::$_prefixes[$namespace] as $base_dir) {
            $file_name = join('/', array(
                rtrim($base_dir, '/'),
                str_replace('\\', '/', $class) . '.php'
            ));

            if (self::include_file($file_name, $just_check)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $file_name
     * @param bool $just_check
     * @return bool
     */
    final private static function include_file(string $file_name, bool $just_check): bool {
        if (is_file($file_name)) {
            if (!$just_check) {
                /* dynamic include classes definition */
                require_once $file_name;
            }
            return true;
        }
        return false;
    }
}
