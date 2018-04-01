<?php
/**
 * StringType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType;
use Here\Config\Constant\SysConstant;
use Here\Lib\Cache\Data\CacheDataBase;


/**
 * Class StringType
 * @package Here\Lib\Cache\Data\DataType
 */
final class StringType extends CacheDataBase {
    /**
     * @return mixed|string
     */
    final protected function default_value() {
        return SysConstant::EMPTY_STRING;
    }

    /**
     * @param string $data
     * @return mixed|void
     */
    public function set_data(string $data) {
        $this->_value = $data;
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return mb_strlen($this->get_value());
    }
}
