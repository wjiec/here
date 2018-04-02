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
use Here\Lib\Cache\Adapter\CacheAdapterInterface;


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
    public function set_expired(int $expired): bool;

    /**
     * @return int
     */
    public function get_expired(): int;

    /**
     * @return bool
     */
    public function remove_expired(): bool;

    /**
     * @return int
     */
    public function get_length(): int;

    /**
     * @return int
     */
    public function destroy(): int;

    /**
     * @param CacheAdapterInterface $adapter
     * @return bool
     */
    public function persistent(CacheAdapterInterface $adapter): bool;
}
