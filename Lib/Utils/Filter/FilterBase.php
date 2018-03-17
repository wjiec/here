<?php
/**
 * FilterBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Filter;


/**
 * Class FilterBase
 * @package Lib\Utils\Filter
 */
abstract class FilterBase implements FilterInterface {
    /**
     * @param mixed $object
     * @param int $options
     * @return bool
     */
    final public static function filter($object, int $options = 0): bool {
        return filter_var($object, static::filter_name());
    }

    /**
     * @return int
     */
    abstract protected static function filter_name(): int;
}
