<?php
/**
 * FilterInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Filter;


/**
 * Interface FilterInterface
 * @package Lib\Utils\Filter
 */
interface FilterInterface {
    /**
     * @param $object
     * @param int $options
     * @return bool
     */
    public static function filter($object, int $options = 0): bool;
}
