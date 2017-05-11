<?php
/**
 * Here Router Module
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Router {
    /**
     * router node tree
     *
     * @var array
     */
    private $_tree = array();

    /**
     * router error handler
     *
     * @var array
     */
    private $_error = array();

    /**
     * hooks methods
     *
     * @var array
     */
    private $_hooks = array();

    /**
     * server variable
     *
     * @var array
     */
    private $_variable = array();

    /**
     * callback params
     *
     * @var array
     */
    private $_callback_params = array();

    /**
     * url validate, using ctype
     *
     * @var array
     */
    private $_validate = array('A' => 'alnum', 'a' => 'alpha', 'd' => 'digit', 'l' => 'lower', 'u' => 'upper');

    /**
     * all http request method
     *
     * @var array
     */
    private static $_request_methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'ALL');

    /**
     * Here_Router constructor.
     */
    public function __construct() {
        # initialize
        $this->_tree = array();
        $this->_error = array();
        $this->_hooks = array();

        # server variables
        $this->_variable['request_method'] = Here_Request::get_env('request_method');
        $this->_variable['current_url'] = parse_url(Here_Request::get_env('request_uri'), PHP_URL_PATH);
    }

    /**
     * register default handler, execute on full-match error handler not found
     *
     * @param callable $callback
     * @throws Here_Exceptions_ParameterError
     */
    public function default_error($callback) {
        if (!is_callable($callback)) {
            throw new Here_Exceptions_ParameterError("parameter type invalid",
                'Here:Router:default_error');
        }
        // create error handler node
        $this->_create_error_handler('__default__', $callback);
    }

    /**
     * add new node to router node tree
     *
     * @param string $call_name
     * @param array $args
     * @return $this
     * @throws Here_Exceptions_RouterError
     */
    public function __call($call_name, $args) {
        $call_name = strtoupper($call_name);

        # new routing
        if (in_array($call_name, self::$_request_methods)) {
            if ($call_name == 'ALL') {
                $methods = self::$_request_methods;
                array_pop($methods);
            } else {
                $methods = array($call_name);
            }

            # filter urls
            $urls = array_shift($args);
            if (!is_array($urls)) {
                $urls = array($urls);
            }
            $urls = array_filter($urls, function($url) {
                return is_string($url);
            });

            # filter callback
            $callback = array_shift($args);
            if (!is_array($callback)) {
                $callback = array($callback);
            }
            $callback = array_filter($callback, function($cb) {
                return is_callable($cb);
            });

            # filter hook
            $hook = array_filter($args, function($hook) {
                return is_string($hook) && array_key_exists($hook, $this->_hooks);
            });

            // create router node
            $this->_create_router($methods, $urls, $callback, $hook);
        // add error/hook handler or dispatch error handler
        } else if (in_array($call_name, array('ERROR', 'HOOK'))) {
            $handler_key = array_shift($args);
            $handler = array_shift($args);

            if (is_callable($handler)) {
                if ($call_name == 'ERROR') {
                    $this->_create_error_handler($handler_key, $handler);
                } else {
                    $this->_create_hook_handler($handler_key, $handler);
                }
            } else {
                if ($call_name == 'ERROR') {
                    $this->emit_error($handler_key, $handler);
                } else {
                    throw new Here_Exceptions_RouterError("can only dispatch error handler",
                        'Here:Router:__call');
                }
            }
        } else {
            throw new Here_Exceptions_RouterError("fatal error: anonymous call({$call_name}) not found",
                'Here:Router:__call');
        }

        return $this;
    }

    /**
     * create multi node by multi HttpMethod/urls
     *
     * @param array $methods
     * @param array $urls
     * @param callable $callback
     * @param array $hook
     * @throws Here_Exceptions_RouterError
     */
    public function match($methods, $urls, $callback, $hook) {
        if (!is_array($methods) && is_string($methods)) {
            $methods = array($methods);
        }
        $methods = array_filter($methods, function(&$method) {
            $method = strtoupper($method);
            return in_array($method, self::$_request_methods);
        });

        if (!is_array($urls) && is_string($urls)) {
            $urls = array($urls);
        }
        $urls = array_filter($urls, function($url) {
            return is_string($url);
        });

        if (!is_callable($callback)) {
            throw new Here_Exceptions_RouterError('callback is non-callable',
                'Here:Router:match');
        } else {
            $callback = array($callback);
        }

        if (!is_array($hook) && is_string($hook)) {
            $hook = array($hook);
        } else if (is_array($hook)) {
            $hook = array_filter($hook, function($hook) {
                return is_string($hook) && array_key_exists($hook, $this->_hooks);
            });
        }

        $this->_create_router($methods, $urls, $callback, $hook);
    }

    /**
     * ! Please do not use this method, this method is very dangerous
     *
     * @param array $router_tree
     * @param array $router_error
     * @param array $router_hooks
     */
    public function __import_router_tree(array $router_tree, array $router_error, array $router_hooks) {
        $this->_tree = $router_tree;
        $this->_error = $router_error;
        $this->_hooks = $router_hooks;
    }

    /**
     * export internal variables
     *
     * @return array
     */
    public function __export_router_tree() {
        return array(
            'tree'  => $this->_tree,
            'error' => $this->_error,
            'hooks' =>$this->_hooks
        );
    }

    /**
     * import router table
     *
     * @param array $route_classes
     */
    public function import_router_table($route_classes) {
        $error_routes = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Error') === 0) {
                return true;
            }
            return false;
        });
        $hook_routes = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Hook') === 0) {
                return true;
            }
            return false;
        });
        $path_route = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Route') === 0) {
                return true;
            }
            return false;
        });

        $this->_parser_error_route($error_routes);
        $this->_parser_hook_route($hook_routes);
        $this->_parser_path_route($path_route);
    }

    /**
     * router entry point
     *
     * @param string $request_method
     * @param string $request_url
     */
    public function entry($request_method = null, $request_url = null) {
        // Since PHP 5.3, it is possible to leave out the middle part of the ternary operator.
        $request_method = strtoupper($request_method ?: $this->_variable['request_method']);
        $request_url = $request_url ?: $this->_variable['current_url'];

        $this->_callback_params = array(
            '__url__' => $request_url,
            '__method__' => $request_method,
        );

        list($callback, $hooks) = $this->_resolve($request_method, $request_url, $this->_callback_params);

        // raise error
        if (($callback == null && $hooks == null) || (empty($callback) && empty($hooks))) {
            if (array_key_exists('errno', $this->_callback_params)) {
                $this->emit_error($this->_callback_params['errno'], $this->_callback_params);
            } else {
                $this->_callback_params['errno'] = '500';
                $this->_callback_params['error'] = 'server internal error';

                $this->emit_error($this->_callback_params['errno'], $this->_callback_params);
            }

            if (_here_hook_error_after_exit_ == true) {
                exit();
            }
        }

       // check hook return value is true?
        if (!empty($hooks)) {
            foreach ($hooks as $hook) {
                if (!$this->_emit_hook($hook, $this->_callback_params)) {
                    $this->_callback_params['errno'] = _here_hook_emit_error_;
                    $this->_callback_params['error'] = 'url hook function validate error';
                    $this->emit_error($this->_callback_params['errno'], $this->_callback_params);

                    # sys definition value
                    if (_here_hook_error_after_exit_ == true) {
                        exit();
                    }
                }
            }
        }

        # callback function
        if (!empty($callback)) {
            array_map(function($cb) {
                call_user_func_array($cb, array($this->_callback_params));
            }, $callback);
        }
    }

    /**
     * trigger error handler
     *
     * @param string|int $error_code
     * @throws Here_Exceptions_RouterError
     */
    public function emit_error($error_code/* ... other args ... */) {
        $error_code = intval($error_code);
        Here_Request::set_http_code($error_code);

        if (!array_key_exists($error_code, $this->_error)) {
            if (!array_key_exists('__default__', $this->_error)) {
                throw new Here_Exceptions_RouterError("error handler or default handler not found",
                    'Here:Router:emit_error');
            }
            // change to default error handler
            $error_code = '__default__';
        }

        $args = func_get_args();
        if (call_user_func($this->_error[$error_code], $args) || _here_emit_error_after_exit_) {
            exit;
        }
    }

    /**
     * getting request method
     *
     * @return string
     */
    public function request_method() {
        return $this->_variable['request_method'];
    }

    /**
     * getting current request url
     *
     * @return string
     */
    public function current_url() {
        return $this->_variable['current_url'];
    }

    /**
     * trigger hook method
     *
     * @param string $hook_name
     * @param array $params
     * @return mixed
     */
    private function _emit_hook($hook_name, $params) {
        return $this->_hooks[$hook_name]($params);
    }

    /**
     * create router node to router tree
     *
     * @param array $methods
     * @param array $urls
     * @param callable $callback
     * @param array $hook
     * @return $this
     */
    private function _create_router($methods, $urls, $callback, $hook) {
        foreach ($methods as $method) {
            if (!array_key_exists($method, $this->_tree)) {
                $this->_tree[$method] = array();
            }

            foreach ($urls as $url) {
                $trim_url = trim($url, self::$URL_SEPARATOR);
                $new_node = explode(self::$URL_SEPARATOR, str_replace('.', self::$URL_SEPARATOR, $trim_url));
                $this->_create_router_node($this->_tree[$method], $new_node, $callback, $hook);
            }
        }
        return $this;
    }

    /**
     * Create routing node recursive
     *
     * @param array $tree
     * @param array $new_node
     * @param callable $callback
     * @param array $hook
     * @return $this|Here_Router
     * @throws Here_Exceptions_RouterError
     */
    private function _create_router_node(&$tree, $new_node, $callback, $hook) {
        $current_node = array_shift($new_node);

        # variable router node
        if ($current_node && $current_node[0] == self::$VAR_ROUTER) {
            if (!array_key_exists(self::$VAR_ROUTER, $tree)) {
                $tree[self::$VAR_ROUTER] = array();
            }

            $var_router_name = substr($current_node, 1);
            if (!array_key_exists($var_router_name, $tree[self::$VAR_ROUTER])) {
                $tree[self::$VAR_ROUTER][$var_router_name] = array();
            }
            return self::_create_router_node($tree[self::$VAR_ROUTER][$var_router_name], $new_node, $callback, $hook);
        }

        # re match router node
        if ($current_node && $current_node[0] == self::$RE_ROUTER) {
            if (!array_key_exists(self::$RE_ROUTER, $tree)) {
                $tree[self::$RE_ROUTER] = array();
            }

            $re_router_name = substr($current_node, 1);
            if (!array_key_exists($re_router_name, $tree[self::$RE_ROUTER])) {
                $tree[self::$RE_ROUTER][$re_router_name] = array();
            }
            return self::_create_router_node($tree[self::$RE_ROUTER][$re_router_name], $new_node, $callback, $hook);
        }

        # full-match, $current_node === '...'
        if ($current_node && $current_node === self::$FULL_MATCH) {
            // check full-match is end-node
            if (count($new_node) !== 0) {
                throw new Here_Exceptions_RouterError("full-match must be in the end-node",
                    'Here:Router:_create_router_node');
            }
            // create node
            if (!array_key_exists(self::$FULL_MATCH, $tree)) {
                $tree[self::$FULL_MATCH] = array();

                return self::_create_router_node($tree[$current_node], $new_node, $callback, $hook);
            }
        }

        // this node is created
        if ($current_node && array_key_exists($current_node, $tree)) {
            return self::_create_router_node($tree[$current_node], $new_node, $callback, $hook);
        } else if ($current_node) {
            $tree[$current_node] = array();
            return self::_create_router_node($tree[$current_node], $new_node, $callback, $hook);
        }

        // create handler node
        if (!array_key_exists(self::$HANDLE, $tree)) {
            $tree[self::$HANDLE] = array(
                self::$CALLBACK => array(),
                self::$HOOK => array()
            );
        }

        # write router handler
        if ($new_node == null) {
            $tree[self::$HANDLE][self::$CALLBACK] = array_merge($tree[self::$HANDLE][self::$CALLBACK], $callback);
            $tree[self::$HANDLE][self::$HOOK] = array_merge($tree[self::$HANDLE][self::$HOOK], $hook);
        }

        return $this;
    }

    /**
     * create error handler
     *
     * @param string|int $error
     * @param callable $handler
     */
    private function _create_error_handler($error, $handler) {
        $this->_error[$error] = $handler;
    }

    /**
     * create hook handler
     *
     * @param string $hook_name
     * @param callable $handler
     */
    private function _create_hook_handler($hook_name, $handler) {
        $this->_hooks[$hook_name] = $handler;
    }

    /**
     * from router tree find callback and hook name
     *
     * @param string $request_method
     * @param string $request_url
     * @param array $params
     * @return array
     */
    private function _resolve($request_method, $request_url, &$params) {
        if (!array_key_exists($request_method, $this->_tree)) {
            $params['errno'] = '405';
            $params['error'] = 'Request failed: method not allowed';

            return array(null, null);
        }

        $trim_url = trim($request_url, self::$URL_SEPARATOR);
        $nodes = explode(self::$URL_SEPARATOR, str_replace('.', self::$URL_SEPARATOR, $trim_url));

        return $this->_search_router($this->_tree[$request_method], $nodes, $params);
    }

    private function _search_router($tree, $nodes, &$params) {
        $require_node = array_shift($nodes);

        # search completed
        if ($require_node == null) {
            if (array_key_exists(self::$HANDLE, $tree)) {
                return array($tree[self::$HANDLE][self::$CALLBACK], $tree[self::$HANDLE][self::$HOOK]);
            } else {
                $params['errno'] = '404';
                $params['error'] = 'router handler not defined';

                return array(null, null);
            }
        }

        # first, full matching router
        foreach ($tree as $node => $value) {
            // if full-match
            if ($node == $require_node) {
                // matching next node
                return $this->_search_router($tree[$node], $nodes, $params);
            }
        }

        # check variable routing exists
        if (empty($tree[self::$RE_ROUTER]) && empty($tree[self::$VAR_ROUTER]) && empty($tree[self::$FULL_MATCH])) {
            $params['errno'] = '404';
            $params['error'] = 'no matching router';

            return array(null, null);
        }

        # second, re matching routing: @
        if (!empty($tree[self::$RE_ROUTER])) {
            $re_nodes = $tree[self::$RE_ROUTER];

            foreach ($re_nodes as $re => $node) {
                $re_name = null;
                $test_re = $re;
                $re_name_pos = strpos($re, self::$RE_ROUTER);

                if ($re_name_pos && $re[$re_name_pos - 1] != '\\') {
                    $re_name = substr($test_re, $re_name_pos + 1);
                    $test_re = substr($re, 0, $re_name_pos);
                }

                # @^pattern$@, must be full matching
                $test_re = self::$RE_ROUTER . '^' . $test_re . '$' . self::$RE_ROUTER;
                if (preg_match($test_re, $require_node, $matches)) {
                    if (array_key_exists('errno', $params)) {
                        unset($params['errno']);
                        unset($params['error']);
                    }

                    if ($re_name && is_string($re_name)) {
                        $params['re'][$re_name] = $matches[0];
                    }
                } else {
                    $params['errno'] = '404';
                    $params['error'] = 'no re-matching routing';

                    continue;
                }

                list($callback, $hooks) = $this->_search_router($re_nodes[$re], $nodes, $params);

                if ($callback != null) {
                    if ($re_name == null) {
                        $params['re'] = array_key_exists('re', $params) ? array_merge($params['re'], $matches) : $matches;
                    }

                    return array($callback, $hooks);
                } else {
                    if ($re_name != null) {
                        unset($params['re'][$re_name]);
                    }
                }
            }
        }

        # variable-routing: $
        if (!empty($tree[self::$VAR_ROUTER])) {
            $var_node = $tree[self::$VAR_ROUTER];
            foreach ($var_node as $key => $val) {
                $pos = strpos($key, ':');
                if ($pos) {
                    if (array_key_exists($key[$pos + 1], $this->_validate) &&
                        !call_user_func('ctype_' . $this->_validate[$key[$pos + 1]], $require_node)) {
                        $params['errno'] = '404';
                        $params['error'] = 'var-matching validate failure';

                        continue;
                    } else {
                        unset($params['errno']);
                        unset($params['error']);
                    }
                }

                $params[$pos ? substr($key, 0, $pos) : $key] = $require_node;
                list($callback, $hooks) = $this->_search_router($var_node[$key], $nodes, $params);

                if ($callback != null) {
                    return array($callback, $hooks);
                }
                unset($params[$key]);
            }
        }

        # full-match routing
        if (!empty($tree[self::$FULL_MATCH])) {
            $explode_nodes = explode(self::$URL_SEPARATOR, self::current_url());
            foreach ($explode_nodes as $index => $node) {
                if ($node != $require_node) {
                    // !!! allow operation array?
                    array_shift($explode_nodes);
                } else {
                    break;
                }
            }
            $params['full_match_url'] = join(self::$URL_SEPARATOR, $explode_nodes);

            return array(
                $tree[self::$FULL_MATCH][self::$HANDLE][self::$CALLBACK],
                $tree[self::$FULL_MATCH][self::$HANDLE][self::$HOOK]
            );
        }

        $params['errno'] = '404';
        $params['error'] = 'no matching routing';
        return array(null, null);
    }

    /**
     * parser error router classes
     *
     * @param array $error_route_list
     */
    private function _parser_error_route($error_route_list) {
        foreach ($error_route_list as $error_route) {
            /* @var Here_Abstracts_Route_Error $route_class */
            $route_class = new $error_route();
            $error_code = $route_class->errno();

            $this->_create_error_handler($error_code, array($route_class, 'entry_point'));
        }
    }

    /**
     * parser hook router classes
     *
     * @param array $hook_route_list
     */
    private function _parser_hook_route($hook_route_list) {
        foreach ($hook_route_list as $hook_route) {
            /* @var Here_Abstracts_Route_Hook $route_class */
            $route_class = new $hook_route();
            $hook_name = $route_class->hook_name();

            $this->_create_hook_handler($hook_name, array($route_class, 'entry_point'));
        }
    }

    /**
     * @param $path_route_list
     */
    private function _parser_path_route($path_route_list) {
        foreach ($path_route_list as $path_route) {
            /* @var Here_Abstracts_Route_Route $route_class */
            $route_class = new $path_route();
            $urls = $route_class->urls();
            $methods = $route_class->methods();
            $hooks = $route_class->hooks();

            $this->match($methods, $urls, array($route_class, 'entry_point'), $hooks);
        }
    }

    # url separator
    private static $URL_SEPARATOR = '/';

    # handler
    private static $HANDLE = '=';

    # re match node
    private static $RE_ROUTER = '@';

    # variable router match flag
    private static $VAR_ROUTER = '$';

    # full-match
    private static $FULL_MATCH = '???';

    # callback node
    private static $CALLBACK = '__cb__';

    # hook node
    private static $HOOK = '__hk__';
}
