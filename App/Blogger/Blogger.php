<?php
/**
 * Blogger.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger;
use Here\App\ApplicationInterface;
use Here\Config\Constant\SysConstant;


/**
 * Class Blogger
 * @package Here\App
 */
class Blogger implements ApplicationInterface {
    /**
     * initializing blogger
     */
    final public static function init(): void {
        BloggerEnvironment::init();
    }

    /**
     * @return string
     */
    final public static function get_version(): string {
        return join('.', SysConstant::HERE_VERSION);
    }
}

