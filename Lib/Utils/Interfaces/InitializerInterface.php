<?php
/**
 * InitializerInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Interfaces;


/**
 * Interface InitializerInterface
 * @package Here\Lib\Utils\Interfaces
 */
interface InitializerInterface {
    /**
     * initializing environment
     */
    public static function init(): void;
}
