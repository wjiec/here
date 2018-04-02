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
    final public function set_data(string $data): void {
        $this->_value = $data;
    }

    /**
     * @return string
     */
    final public function default_value() {
        return '';
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return mb_strlen($this->get_value());
    }
}
