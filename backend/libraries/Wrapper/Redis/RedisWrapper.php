<?php
/**
 * RedisWrapper.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\Wrapper\Redis;


use Here\Libraries\Wrapper\WrapperInterface;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Di;


/**
 * Class RedisWrapper
 * @package Here\Libraries\Wrapper\Redis
 */
abstract class RedisWrapper implements WrapperInterface {

    /**
     * @var callable
     */
    private $refresh_callback;

    /**
     * @var Redis
     */
    private static $redis;

    /**
     * RedisWrapper constructor.
     * @param callable $refresh_callback
     * @throws RedisWrapperError
     */
    final public function __construct($refresh_callback) {
        if (!is_callable($refresh_callback)) {
            throw new RedisWrapperError('refresh callback must be callable');
        }
        $this->refresh_callback = $refresh_callback;
    }

    /**
     * @return mixed
     */
    final public function get() {
        if (!self::$redis) {
            self::$redis = Di::getDefault()->get('cache');
        }

        $result = self::$redis->get($this->getRedisKey());
        if ($result === null) {
            $result = call_user_func($this->refresh_callback);
            self::$redis->save($this->getRedisKey(), $result, $this->getRedisExpire());
        }

        return $result;
    }

    /**
     * @return string
     */
    abstract protected function getRedisKey(): string;

    /**
     * @return int
     */
    protected function getRedisExpire(): int {
        return self::NO_EXPIRE;
    }

    protected const NO_EXPIRE = -1;

    protected const EXPIRE_ONE_DAY = 86400;

    protected const EXPIRE_ONE_WEEK = 604800;

    protected const EXPIRE_ONE_MONTH = 2592000;

}
