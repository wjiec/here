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
use Here\Lib\Extension\Callback\CallbackObject;
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
     * @param null|string $name
     * @return DatabaseAdapterInterface
     */
    final public static function get_adapter(?string $name = null): DatabaseAdapterInterface {
        return self::$_adapter;
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return array
     */
    final public static function select(string $sql, ?array $params = null): array {
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return int
     */
    final public static function insert(string $sql, ?array $params = null): int {
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return int
     */
    final public static function update(string $sql, ?array $params = null): int {
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return int
     */
    final public static function delete(string $sql, ?array $params = null): int {
    }

    /**
     * @param CallbackObject $callback
     */
    final public static function transaction(CallbackObject $callback): void {
    }
}
