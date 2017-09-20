<?php
/**
 * Router.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Ext\Callback\CallbackObject;
use Here\Lib\Io\Input\Request;


/**
 * Class Router
 * @package Here\Lib\Router
 */
class Router {
    /**
     * @var array
     */
    private $_routers_tree;

    /**
     * @var array
     */
    private $_errors_handler;

    /**
     * @var array
     */
    private $_hooks_handler;

    /**
     * @var string
     */
    private $_request_method;

    /**
     * @var string
     */
    private $_request_uri;

    /**
     * Router constructor.
     * @param $router_tables
     */
    final public function __construct($router_tables) {
        $this->_routers_tree = array();
        $this->_hooks_handler = array();
        $this->_errors_handler = array();
    }

    /**
     * @param $router_tables
     * @param string|null $request_method
     * @param string|null $request_uri
     * @return bool
     */
    final public static function start_router($router_tables, $request_method = null, $request_uri = null) {
        return (new self($router_tables))->router($request_method, $request_uri);
    }

    /**
     * @param null $request_method
     * @param null $request_uri
     * @throws MethodNotAllowed
     * @return bool
     */
    final public function router($request_method = null, $request_uri = null) {
        $this->_request_uri = $request_uri ?: Request::request_uri();
        $this->_request_method = $request_method ?: Request::request_method();

        // check method is allowed
        if (!in_array($this->_request_method, self::$_ALLOWED_METHODS)) {
            throw new MethodNotAllowed("{$this->_request_method} is not allowed");
        }

        return true;
    }

    /**
     * @param CallbackObject $callback
     */
    final public function default_error_handler(CallbackObject $callback) {
        // do not need to type checking
        $this->_errors_handler['default'] = $callback;
    }

    /**
     * @var array
     */
    private static $_ALLOWED_METHODS = array('get', 'post', 'put', 'update', 'patch', 'delete', 'head');
}
