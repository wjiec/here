<?php
/**
 * HashTableValue.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\HashTable;


use Here\Lib\Cache\Data\CacheDataBase;

/**
 * Class HashTableValue
 *
 * @package Here\Lib\Cache\Data\DataType\HashTable
 */
final class HashTableValue extends CacheDataBase implements HashTableTypeInterface {
    /**
     * @param array $data
     */
    final public function assign(array $data): void {
        $this->destroy();
    }

    /**
     * @return array
     */
    final public function refresh_value() {
        $this->_value = $this->get_adapter()->hash_get($this->_key);
        return $this->_value;
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return $this->get_adapter()->hash_get_length($this->get_key());
    }

    /**
     * @param null $default
     * @param string[] $indexes
     * @return array
     */
    final public function multi_get($default = null, array $indexes): array {
        return $this->get_adapter()->hash_multi_get_item($this->get_key(), $indexes, $default);
    }

    /**
     * @param string[] $indexes
     * @return int
     */
    final public function multi_remove(array $indexes): int {
        return $this->get_adapter()->hash_multi_remove_item($this->get_key(), $indexes);
    }

    /**
     * @param array $data
     * @return int
     */
    final public function update(array $data): int {
        $result = $this->get_adapter()->hash_multi_set_item($this->get_key(), $data);
        $this->refresh_value();
        return $result;
    }

    /**
     * @return array
     */
    final public function keys(): array {
        return $this->get_adapter()->hash_get_keys($this->get_key());
    }

    /**
     * @return array
     */
    final public function values(): array {
        return $this->get_adapter()->hash_get_values($this->get_key());
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    final public function offsetExists($offset): bool {
        return isset($this->get_value()[$offset]);
    }

    /**
     * @param mixed $offset
     * @return null
     */
    final public function offsetGet($offset) {
        if ($this->offsetExists($offset)) {
            return $this->_value[$offset];
        }
        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    final public function offsetSet($offset, $value) {
        $this->get_adapter()->hash_set_item($this->get_key(), $offset, $value);
        $this->_value[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    final public function offsetUnset($offset) {
        $this->get_adapter()->hash_remove_item($this->get_key(), $offset);
        unset($this->_value[$offset]);
    }
}
