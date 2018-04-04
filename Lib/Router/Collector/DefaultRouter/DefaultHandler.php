<?php
/**
 * DefaultHandler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\DefaultRouter;
use Here\Lib\Exceptions\LastException;
use Here\Lib\Router\RouterRequest;


/**
 * Trait DefaultHandler
 * @package Here\Lib\Router\Collector\DefaultRouter
 */
trait DefaultHandler {
    /**
     * @param string $message
     *
     * @routerHandler
     * @defaultHandler
     */
    final public function default_handler(string $message): void {
        echo "<pre>";
        var_dump($message);
        var_dump(sprintf("Default Handler: %s", RouterRequest::request_uri()));
        var_dump(LastException::get_stack_trace());
        echo "</pre>";
    }

    /**
     * @param string $message
     *
     * @routerHandler
     * @addHandler 404
     */
    final public function not_found_handler(string $message): void {
        echo "<pre>";
        var_dump($message);
        var_dump(sprintf("Request Not Found: %s", RouterRequest::request_uri()));
        echo "</pre>";
    }
}
