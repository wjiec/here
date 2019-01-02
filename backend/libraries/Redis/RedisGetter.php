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
     * RedisGetter constructor.
     */
    final public function __construct() {
        if (!self::$cache) {
            self::$cache = Di::getDefault()->get('cache');
        }
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @param int $expired
     * @return mixed
     */
    final public function get(string $name, $default = null, int $expired = 0) {
        if (!self::$cache->exists($name)) {
            if ($default !== null) {
                if (is_callable($default)) {
                    $default = $default();
                }
                self::$cache->save($name, $default, $this->correctExpiredTime($expired));
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
            self::$cache->save($name, $default, $this->correctExpiredTime($expired));
        }
    }

    /**
     * @param int $expired
     * @return int|null
     */
    final private function correctExpiredTime(int $expired): ?int {
        if ($expired === 0) {
            return null;
        }
        return $expired < 0 ? -1 : $expired;
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
