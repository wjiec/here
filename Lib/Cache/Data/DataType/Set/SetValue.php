<?php
/**
 * SetValue.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\Set;
use Here\Lib\Cache\Data\CacheDataBase;


/**
 * Class SetValue
 *
 * @package Here\Lib\Cache\Data\DataType\Set
 */
final class SetValue extends CacheDataBase implements SetTypeInterface {
    /**
     * @param array $set
     */
    final public function assign(array $set): void {
        $this->destroy();
        $this->add(...$set);
    }

    /**
     * @return array
     */
    final public function refresh_value() {
        $this->_value = $this->get_adapter()->set_get($this->get_key());
        return $this->_value;
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return count($this->_value);
    }

    /**
     * @param string[] ...$values
     * @return int
     */
    final public function add(string ...$values): int {
        $result = $this->get_adapter()->set_add($this->get_key(), ...$values);
        $this->refresh_value();
        return $result;
    }

    /**
     * @param string[] ...$values
     * @return int
     */
    final public function remove(string ...$values): int {
        $result = $this->get_adapter()->set_remove($this->get_key(), ...$values);
        $this->refresh_value();
        return $result;
    }

    /**
     * @param string $value
     * @return bool
     */
    final public function exists(string $value): bool {
        return $this->get_adapter()->set_exists($this->get_key(), $value);
    }

    /**
     * @param null|string $default
     * @return null|string
     */
    final public function random_pop(?string $default = null): ?string {
        $result = $this->get_adapter()->set_random_pop($this->get_key(), $default);
        $this->refresh_value();
        return $result;
    }

    /**
     * @param null|string $default
     * @return null|string
     */
    final public function random_cat(?string $default = null): ?string {
        return $this->get_adapter()->set_random_cat($this->get_key(), $default);
    }

    /**
     * @param SetTypeInterface[] ...$keys
     * @return array
     */
    final public function inter(SetTypeInterface ...$keys): array {
        $keys = array_map(function(SetValue $set) {
            return $set->get_key();
        }, $keys);

        return $this->get_adapter()->set_inter($this->get_key(), ...$keys);
    }

    /**
     * @param SetTypeInterface[] ...$keys
     * @return array
     */
    final public function union(SetTypeInterface ...$keys): array {
        $keys = array_map(function(SetValue $set) {
            return $set->get_key();
        }, $keys);

        return $this->get_adapter()->set_union($this->get_key(), ...$keys);
    }

    /**
     * @param SetTypeInterface[] ...$keys
     * @return array
     */
    final public function diff(SetTypeInterface ...$keys): array {
        $keys = array_map(function(SetValue $set) {
            return $set->get_key();
        }, $keys);

        return $this->get_adapter()->set_diff($this->get_key(), ...$keys);
    }
}
