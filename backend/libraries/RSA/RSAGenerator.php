<?php
/**
 * RSAGenerator.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\RSA;


use Here\Libraries\Wrapper\Redis\RedisWrapper;
use Here\Libraries\Wrapper\Redis\RedisWrapperError;
use Here\Libraries\Wrapper\WrapperInterface;


/**
 * Class RSAGenerator
 * @package Here\Libraries\RSA
 */
final class RSAGenerator extends RedisWrapper {

    /**
     * @param int $bits
     * @return WrapperInterface
     * @throws RedisWrapperError
     */
    final public static function generate(int $bits = 1024): WrapperInterface {
        return new static(function () use ($bits) {
            return RSAObject::generate($bits)->getPublicKey();
        });
    }

    /**
     * @return string
     */
    final protected function getRedisKey(): string {
        return self::REDIS_KEY;
    }

    /**
     * @return int
     */
    final protected function getRedisExpire(): int {
        return self::EXPIRE_ONE_DAY;
    }

    private const REDIS_KEY = 'security:rsa';

}

