<?php
/**
 * RedisGetter.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Redis;


use Here\Plugins\AppRedisBackend;
use Phalcon\Di;


/**
 * Class RedisGetter
 * @package Here\libraries\Redis
 */
final class RedisGetter {

    /**
     * @var AppRedisBackend
     */
    private static $cache;

    /**
     * @var bool
     */
    private static $force;

    /**
     * @var int
     */
    private static $default_expired;

    /**
     * RedisGetter constructor.
     */
    final public function __construct() {
        if (!self::$cache) {
            self::$cache = Di::getDefault()->get('cache');
        }

        if (self::$force === null) {
            self::$force = Di::getDefault()->get('request')->hasQuery('force');
        }

        if (self::$default_expired === null) {
            self::$default_expired = Di::getDefault()->get('config')->cache->frontend->lifetime;
        }
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @param int $expired
     * @return mixed
     */
    final public function get(string $name, $default = null, int $expired = 0) {
        if ($expired === 0) {
            $expired = self::$default_expired;
        } else if ($expired < 0) {
            $expired = -1;
        }

        if (!self::$cache->exists($name)) {
            if ($default !== null) {
                if (is_callable($default)) {
                    $default = $default();
                }
                self::$cache->save($name, $default, $expired);
            }
            return $default;
        }
        return self::$cache->get($name);
    }

    /**
     * @param string $name
     * @param null $default
     * @param int $expired
     */
    final public function refresh(string $name, $default = null, int $expired = 0) {
        if ($default !== null) {
            if (is_callable($default)) {
                $default = $default();
            }
            self::$cache->save($name, $default, $expired);
        }
    }

    /**
     * unlimited lifetime
     */
    public const NO_EXPIRE = -1;

    /**
     * 1-hour lifetime
     */
    public const EXPIRE_ONE_HOURS = 3600;

    /**
     * 1-day lifetime
     */
    public const EXPIRE_ONE_DAY = 86400;

}
