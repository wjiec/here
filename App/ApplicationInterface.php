<?php
/**
 * ApplicationInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App;


/**
 * Interface ApplicationInterface
 * @package Here\App
 */
interface ApplicationInterface extends InitializerInterface {
    /**
     * @return string
     */
    public static function get_version(): string;
}
