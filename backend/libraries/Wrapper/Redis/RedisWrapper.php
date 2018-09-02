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


use Here\Libraries\Wrapper\WrapperBase;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Di;


/**
 * Class RedisWrapper
 * @package Here\Libraries\Wrapper\Redis
 */
abstract class RedisWrapper extends WrapperBase {

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
        parent::__construct();

        if (!is_callable($refresh_callback)) {
            throw new RedisWrapperError('refresh callback must be callable');
        }
        $this->refresh_callback = $refresh_callback;
    }

    /**
     * @param bool $force
     * @return mixed
     */
    final public function get(bool $force = false) {
        if (!self::$redis) {
            self::$redis = Di::getDefault()->get('cache');
        }

        $result = self::$redis->get($this->getRedisKey());
        if ($result === null || $force) {
            $result = call_user_func_array($this->refresh_callback, array($this));
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
