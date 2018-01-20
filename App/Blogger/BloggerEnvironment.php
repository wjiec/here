<?php
/**
 * BloggerEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger;
use Here\App\InitializerInterface;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Stream\OStream\Client\Response;


/**
 * Class BloggerEnvironment
 * @package Here\App\Blogger
 */
final class BloggerEnvironment implements InitializerInterface {
    /**
     * initializing blogger environment
     */
    public static function init(): void {
        // response environment
        Response::init();

        // Gl0balException environment
        GlobalExceptionHandler::init();
    }
}
