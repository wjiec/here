<?php
/**
 * CacheAdapterInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Adapter;


/**
 * Interface CacheAdapterInterface
 * @package Here\Lib\Cache\Adapter
 */
interface CacheAdapterInterface {
    /**
     * @param string $key
     * @return int
     */
    public function destroy_item(string $key): int;

    /**
     * @param string $key
     * @return bool
     */
    public function persist_item(string $key): bool;

    /**
     * @param string $key
     * @return int
     */
    public function get_ttl(string $key): int;

    /**
     * @param string $key
     * @param int $expired
     * @return bool
     */
    public function set_ttl(string $key, int $expired): bool;

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function string_item_cache(string $key, string $value): bool;
}
