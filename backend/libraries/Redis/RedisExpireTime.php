<?php
/**
 * RedisExpireTime
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Redis;


/**
 * Class RedisExpireTime
 * @package Here\Libraries\Redis
 */
final class RedisExpireTime {

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
