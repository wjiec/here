<?php
/**
 * CacheRepository.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache;
use Here\Lib\Cache\Adapter\AdapterNotFound;
use Here\Lib\Cache\Adapter\CacheAdapterInterface;
use Here\Lib\Cache\Config\CacheServerConfigInterface;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Utils\Toolkit\StringToolkit;


/**
 * Class CacheManager
 * @package Here\Lib\Cache
 */
final class CacheRepository {
    /**
     * @var CacheAdapterInterface
     */
    private static $_adapter;

    /**
     * @param CacheServerConfigInterface $config
     * @throws AdapterNotFound
     */
    final public static function add_server(CacheServerConfigInterface $config): void {
        $adapter_name = ucfirst($config->get_driver());
        $adapter_class = StringToolkit::format('%s\Adapter\%s\%sAdapter',
            __NAMESPACE__, $adapter_name, $adapter_name);
        if (!Autoloader::class_exists($adapter_class)) {
            throw new AdapterNotFound("cannot found `{$adapter_name}` adapter");
        }

        self::$_adapter = new $adapter_class($config);
    }

    /**
     * @return CacheAdapterInterface
     */
    final public static function get_adapter(): CacheAdapterInterface {
        /**
         * @todo not security?
         */
        return self::$_adapter;
    }
}
