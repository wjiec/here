<?php
/**
 * AvailableInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Interfaces;


/**
 * Interface AvailableInterface
 * @package Lib\Utils\Interfaces
 */
interface AvailableInterface {
    /**
     * @return bool
     */
    public static function available(): bool;
}
