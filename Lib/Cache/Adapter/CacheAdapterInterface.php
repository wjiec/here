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
    public function typeof(string $key): int;

    /**
     * @param string $key
     * @return int
     */
    public function delete_item(string $key): int;

    /**
     * @param string $key
     * @return bool
     */
    public function remove_expire(string $key): bool;

    /**
     * @param string $key
     * @return int
     */
    public function get_expire(string $key): int;

    /**
     * @param string $key
     * @param int $expired
     * @return bool
     */
    public function set_expire(string $key, int $expired): bool;

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function string_create(string $key, string $value): bool;

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function string_get(string $key, string $default): string;

    /**
     * @param string $key
     * @return int
     */
    public function string_get_length(string $key): int;

    /**
     * @param string $key
     * @param string $concat_string
     * @return int
     */
    public function string_concat(string $key, string $concat_string): int;

    /**
     * @param string $key
     * @return int
     */
    public function string_increment(string  $key): int;

    /**
     * @param string $key
     * @return int
     */
    public function string_decrement(string $key): int;

    /**
     * @param string $key
     * @return array
     */
    public function list_get(string $key): array;

    /**
     * @param string $key
     * @return int
     */
    public function list_get_length(string $key): int;

    /**
     * @param string $key
     * @param array ...$values
     * @return int
     */
    public function list_push(string $key, ...$values): int;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function list_pop(string $key, $default = null);

    /**
     * @param string $key
     * @param array ...$values
     * @return int
     */
    public function list_unshift(string $key, ...$values): int;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function list_shift(string $key, $default = null);

    /**
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function list_range(string $key, int $start, int $end): array;

    /**
     * @param string $key
     * @param int $index
     * @param mixed $new_value
     * @return bool
     */
    public function list_set_item(string $key, int $index, $new_value): bool;

    /**
     * @param string $key
     * @param int $index
     * @return int
     */
    public function list_remove_item(string $key, int $index): int;

    /**
     * @param string $key
     * @return array
     */
    public function hash_get(string $key): array;

    /**
     * @param string $key
     * @return int
     */
    public function hash_get_length(string $key): int;

    /**
     * @param string $key
     * @param string $index
     * @param mixed|null $default
     * @return string|null
     */
    public function hash_get_item(string $key, string $index, $default = null): ?string;

    /**
     * @param string $key
     * @param array $indexes
     * @param mixed|null $default
     * @return array
     */
    public function hash_multi_get_item(string $key, array $indexes, $default = null): array;

    /**
     * @param string $key
     * @param string $index
     * @param string $val
     * @return int
     */
    public function hash_set_item(string $key, string $index, string $val): int;

    /**
     * @param string $key
     * @param array $values
     * @return int
     */
    public function hash_multi_set_item(string $key, array $values): int;

    /**
     * @param string $key
     * @param string $index
     * @return int
     */
    public function hash_remove_item(string $key, string $index): int;

    /**
     * @param string $key
     * @param string[] $index
     * @return int
     */
    public function hash_multi_remove_item(string $key, array $index): int;

    /**
     * @param string $key
     * @return array
     */
    public function hash_get_keys(string $key): array;

    /**
     * @param string $key
     * @return array
     */
    public function hash_get_values(string $key): array;

    /**
     * @param string $key
     * @return array
     */
    public function set_get(string $key): array;

    /**
     * @param string $key
     * @param string[] ...$values
     * @return int
     */
    public function set_add(string $key, string ...$values): int;

    /**
     * @param string $key
     * @param string[] ...$values
     * @return int
     */
    public function set_remove(string $key, string ...$values): int;

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set_exists(string $key, string $value): bool;

    /**
     * @param string $key
     * @param null|string $default
     * @return null|string
     */
    public function set_random_pop(string $key, ?string $default = null): ?string;

    /**
     * @param string $key
     * @param null|string $default
     * @return null|string
     */
    public function set_random_cat(string $key, ?string $default = null): ?string;

    /**
     * @param string[] ...$keys
     * @return array
     */
    public function set_inter(string ...$keys): array;

    /**
     * @param string[] ...$keys
     * @return array
     */
    public function set_union(string ...$keys): array;

    /**
     * @param string[] ...$keys
     * @return array
     */
    public function set_diff(string ...$keys): array;

    /**
     * @param string $key
     * @return array
     */
    public function order_set_get(string $key): array;

    /**
     * @param string $key
     * @param array $data
     * @return int
     */
    public function order_set_add(string $key, array $data): int;

    /**
     * @param string $key
     * @param string[] ...$values
     * @return int
     */
    public function order_set_remove(string $key, string ...$values): int;

    /**
     * @param string $key
     * @param string $value
     * @return int
     */
    public function order_set_score(string $key, string $value): int;

    /**
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function order_set_range(string $key, int $start, int $end): array;

    /**
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function order_set_reverse_range(string $key, int $start, int $end): array;

    /**
     * @param string $key
     * @param string $value
     * @return int
     */
    public function order_set_rank(string $key, string $value): int;

    /**
     * @param string $key
     * @param string $value
     * @return int
     */
    public function order_set_reverse_rank(string $key, string $value): int;
}
