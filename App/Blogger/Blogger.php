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
use Here\Config\Router\UserCollector;
use Here\Lib\Router\Dispatcher;
use Here\Lib\Stream\IStream\Client\Request;
use Here\Lib\Stream\OStream\Client\Response;


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
        BloggerEnvironment::init_config('configure.json');
    }

    /**
     * start blogger service
     */
    final public static function start_service(): void {
        /* test case */
        echo "<pre>";

        /* dispatch request resources */
        if (php_sapi_name() !== 'cli') {
            /* create dispatcher for global */
            $dispatcher = new Dispatcher(new UserCollector());
            /* dispatch on cgi mode */
            $dispatcher->dispatch(Request::request_method(), Request::request_uri());
        } else {
            /* commit directly */
            Response::commit();
        }

        /* test case */
        echo "</pre>";
    }

    /**
     * @return string
     */
    final public static function get_version(): string {
        return join('.', SysConstant::HERE_VERSION);
    }
}

