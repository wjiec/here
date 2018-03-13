<?php
/**
 * CollectorInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\Channel\RouterChannel;


/**
 * Interface CollectorInterface
 * @package Here\Lib\Router\Collector
 */
interface CollectorInterface {
    /**
     * @param string $request_method
     * @param string $request_uri
     * @return RouterChannel
     */
    public function dispatch(string $request_method, string $request_uri): RouterChannel;

    /**
     * @param string $middleware_name
     */
    public function start_middleware(string $middleware_name): void;
}
