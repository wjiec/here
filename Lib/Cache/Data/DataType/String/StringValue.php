<?php
/**
 * StringValue.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\String;
use Here\Lib\Cache\Data\CacheDataBase;


/**
 * Class StringValue
 * @package Here\Lib\Cache\Data\DataType\String
 */
final class StringValue extends CacheDataBase implements StringTypeInterface {
    /**
     * @param string $data
     */
    final public function create_new(string $data): void {
        $this->_value = $data;
    }

    /**
     * @return string
     */
    final protected function refresh_value() {
        return $this->get_adapter()->string_get($this->get_key(), '');
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return mb_strlen($this->get_value())
            ?? $this->get_adapter()->string_get_length($this->get_key());
    }

    /**
     * @param string $concat_string
     * @return int
     */
    final public function concat(string $concat_string): int {
        return $this->get_adapter()->string_concat($this->get_key(), $concat_string);
    }
}
