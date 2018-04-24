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
use Here\Lib\Database\Model\Collection\DatabaseModelCollectionInterface;
use Here\Lib\Database\Model\DatabaseModelNotFound;
use Here\Lib\Database\Model\Proxy\DatabaseModelProxy;
use Here\Lib\Database\Model\Proxy\DatabaseModelProxyInterface;
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
     * @param string $model_class
     * @return DatabaseModelProxyInterface
     * @throws DatabaseModelNotFound
     */
    final public static function create_model(string $model_class): DatabaseModelProxyInterface {
        if (!Autoloader::class_exists($model_class)) {
            throw new DatabaseModelNotFound("cannot found model definition for '{$model_class}'");
        }
        return new DatabaseModelProxy(new $model_class());
    }

    /**
     * @param CallbackObject $callback
     */
    final public static function create_transaction(CallbackObject $callback): void {
    }

    /**
     * @param string $model_name
     * @return DatabaseModelCollectionInterface
     */
    final public static function all(string $model_name): DatabaseModelCollectionInterface {
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
}
