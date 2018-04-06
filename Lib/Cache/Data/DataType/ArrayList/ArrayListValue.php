<?php
/**
 * ArrayListValue.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\ArrayList;


use Here\Lib\Cache\Data\CacheDataBase;
use Here\Lib\Utils\Toolkit\StringToolkit;

/**
 * Class ArrayListValue
 *
 * @package Here\Lib\Cache\Data\DataType\ArrayList
 */
final class ArrayListValue extends CacheDataBase implements ArrayListTypeInterface {
    /**
     * @param array $data
     */
    final public function assign(array $data): void {
        $this->destroy();
        $this->get_adapter()->list_push($this->get_key(), ...$data);
        $this->_value = $this->refresh_value();
    }

    /**
     * @return array
     */
    final public function refresh_value() {
        return $this->get_length() === 0 ? array()
            : $this->get_adapter()->list_get($this->get_key());
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return $this->get_adapter()->list_get_length($this->get_key());
    }

    /**
     * @param array ...$values
     * @return int
     */
    final public function push(...$values): int {
        $result = $this->get_adapter()->list_push($this->get_key(), ...$values);
        $this->_value = $this->refresh_value();
        return $result;
    }

    /**
     * @param null $default
     * @return mixed
     */
    final public function pop($default = null) {
        $result = $this->get_adapter()->list_pop($this->get_key(), $default);
        $this->_value = $this->refresh_value();
        return $result;
    }

    /**
     * @param array ...$values
     * @return int
     */
    final public function unshift(...$values): int {
        $result = $this->get_adapter()->list_unshift($this->get_key(), ...$values);
        $this->_value = $this->refresh_value();
        return $result;
    }

    /**
     * @param null $default
     * @return mixed
     */
    final public function shift($default = null) {
        $result =  $this->get_adapter()->list_shift($this->get_key(), $default);
        $this->_value = $this->refresh_value();
        return $result;
    }

    /**
     * @param mixed $offset
     * @return bool
     * @throws \TypeError
     */
    final public function offsetExists($offset): bool {
        if (!is_integer($offset)) {
            throw new \TypeError(StringToolkit::format("ListArray type except integer offset, got %s type",
                gettype($offset)));
        }

        $list = $this->get_value();
        if (is_array($list)) {
            return isset($list[$offset]);
        }
        return false;
    }

    /**
     * @param mixed $offset
     * @throws \TypeError
     * @return mixed
     */
    final public function offsetGet($offset) {
        if ($this->offsetExists($offset)) {
            return $this->get_value()[$offset];
        }
        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    final public function offsetSet($offset, $value) {
        if ($this->offsetExists($offset)) {
            $this->get_adapter()->list_set_item($this->get_key(), $offset, $value);
        } else {
            $this->push($value);
        }

        $this->_value = $this->refresh_value();
    }

    /**
     * @param mixed $offset
     */
    final public function offsetUnset($offset) {
        if ($this->offsetExists($offset)) {
            $this->get_adapter()->list_remove_item($this->get_key(), $offset);
            $this->_value = $this->refresh_value();
        }
    }
}
