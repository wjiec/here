<?php
/**
 * CacheServerConfigInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache;


/**
 * Interface CacheServerConfigInterface
 * @package Here\Lib\Cache
 */
interface CacheServerConfigInterface {
    /**
     * @return string
     */
    public function get_host(): string;

    /**
     * @param int $default_port
     * @return int
     */
    public function get_port(int $default_port): int;

    /**
     * @return null|string
     */
    public function get_username(): ?string;

    /**
     * @return null|string
     */
    public function get_password(): ?string;
}
