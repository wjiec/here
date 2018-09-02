<?php
/**
 * Author.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Models\Wrapper;


use Here\Libraries\Wrapper\Redis\RedisWrapper;
use Here\Libraries\Wrapper\WrapperInterface;
use Here\Models\Users;


/**
 * Class Author
 * @package Here\Models\Wrapper
 */
final class Author extends RedisWrapper {

    /**
     * @return WrapperInterface
     * @throws \Here\Libraries\Wrapper\Redis\RedisWrapperError
     */
    final public static function generate(): WrapperInterface {
        return new static(function() {
            $author = Users::findFirst();
            if (!$author) {
                return false;
            }
            return $author->toArray();
        });
    }

    /**
     * @return string
     */
    final protected function getRedisKey(): string {
        return 'author:info';
    }

    /**
     * @return int
     */
    final protected function getRedisExpire(): int {
        return self::NO_EXPIRE;
    }

}
