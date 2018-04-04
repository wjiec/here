<?php
/**
 * CacheDataInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data;


/**
 * Interface CacheDataInterface
 * @package Here\Lib\Cache\Data
 */
interface CacheDataInterface {
    /**
     * CacheDataInterface constructor.
     * @param string $key
     */
    public function __construct(string $key);

    /**
     * @return string
     */
    public function get_key(): string;

    /**
     * @return mixed
     */
    public function get_value();

    /**
     * @param int $expired
     * @return bool
     */
    public function set_expire(int $expired): bool;

    /**
     * @return int
     */
    public function get_expire(): int;

    /**
     * @return bool
     */
    public function remove_expire(): bool;

    /**
     * @return int
     */
    public function get_length(): int;

    /**
     * @return int
     */
    public function destroy(): int;
}
