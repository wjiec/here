<?php
/**
 * AuthorControllerBase
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers\Base;


use Here\Libraries\Redis\RedisExpireTime;
use Here\Libraries\Redis\RedisGetter;
use Here\Libraries\Redis\RedisKeys;
use Here\Models\Authors;


/**
 * Class AuthorControllerBase
 * @package Here\controllers
 */
abstract class AuthorControllerBase extends ControllerBase {

    /**
     * @return Authors|null
     */
    final protected function getCachedAuthor(): ?Authors {
        return (new RedisGetter())->get(RedisKeys::getAuthorRedisKey(), function() {
            return Authors::findFirst() ?: null;
        }, RedisExpireTime::NO_EXPIRE);
    }

}
