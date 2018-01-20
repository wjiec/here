<?php
/**
 * InitializerInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App;


/**
 * Interface InitializerInterface
 * @package Here\App\Blogger
 */
interface InitializerInterface {
    /**
     * initializing environment
     */
    public static function init(): void;
}
