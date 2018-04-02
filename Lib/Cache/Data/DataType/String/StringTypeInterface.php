<?php
/**
 * StringTypeInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\String;
use Here\Lib\Cache\Data\CacheDataInterface;


/**
 * Interface StringTypeInterface
 * @package Here\Lib\Cache\Data\DataType\String
 */
interface StringTypeInterface extends CacheDataInterface {
    /**
     * @param string $data
     */
    public function set_data(string $data): void;
}
