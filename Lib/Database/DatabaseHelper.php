<?php
/**
 * DatabaseHelper.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database;
use Here\Lib\Database\Adapter\DatabaseAdapterInterface;
use Here\Lib\Database\Adapter\DatabaseAdapterNotFound;
use Here\Lib\Database\Config\DatabaseServerConfigInterface;
use Here\Lib\Database\Model\DatabaseModelInterface;
use Here\Lib\Database\Model\DatabaseModelNotFound;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Utils\Toolkit\StringToolkit;

/**
 * @TODO database todo list
 *  1. transaction
 *  2. auto inject adapter ?
 *  3.
 */



/**
 * Class DatabaseHelper
 * @package Here\Lib\Database
 */
final class DatabaseHelper {
    /**
     * @var DatabaseAdapterInterface
     */
    private static $_adapter;

    /**
     * @param DatabaseServerConfigInterface $server
     * @throws DatabaseAdapterNotFound
     */
    final public static function add_server(DatabaseServerConfigInterface $server): void {
        $driver = ucfirst($server->get_driver());
        $adapter_class = StringToolkit::format('%s\Adapter\%s\%sAdapter',
            __NAMESPACE__, $driver, $driver);
        if (!Autoloader::class_exists($adapter_class)) {
            throw new DatabaseAdapterNotFound("cannot found `{$adapter_class}` adapter");
        }

        self::$_adapter = new $adapter_class($server);
    }

    /**
     * @return DatabaseAdapterInterface
     */
    final public static function get_adapter(): DatabaseAdapterInterface {
        return self::$_adapter;
    }
}
