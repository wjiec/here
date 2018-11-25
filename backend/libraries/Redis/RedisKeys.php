<?php
/**
 * RedisKeys.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Redis;


/**
 * Class RedisKeys
 * @package Here\libraries\Redis
 */
final class RedisKeys {

    private const SECURITY_RSA_KEY = 'security:rsa:private';

    /**
     * @return string
     */
    final public static function getRSAPrivateRedisKey(): string {
        return self::SECURITY_RSA_KEY;
    }

    private const BLOG_AUTHOR_KEY = 'blog:author';

    /**
     * @return string
     */
    final public static function getAuthorRedisKey(): string {
        return self::BLOG_AUTHOR_KEY;
    }

}
