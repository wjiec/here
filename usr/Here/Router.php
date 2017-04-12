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
    # routing tree
    private $_tree = array();

    # error handler
    private $_error = array();

    # hook function
    private $_hooks = array();

    # server variable
    private $_variable = array();

    # callback params
    private $_callback_params = array();

    # url validate, using ctype_
    private $_validate = array('A' => 'alnum', 'a' => 'alpha', 'd' => 'digit', 'l' => 'lower', 'u' => 'upper');

    # all http request method
    private static $_request_methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'ALL');

    # construct function
    public function __construct() {
        # initailze
        $this->_tree = array();
        $this->_error = array();
        $this->_hooks = array();

        # server variables
        $this->_variable['request_method'] = $_SERVER['REQUEST_METHOD'];
        $this->_variable['current_url'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    # add new router node
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

            $this->_create_router($methods, $urls, $callback, $hook);
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
                $this->emit_error($handler_key, $handler);
            }
        } else {
            throw new Exception("fatal error: anyonmous call({$call_name}) not found");
        }

        return $this;
    }

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
            throw new Exception('callback is non-callable', 1996);
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

    # ! please don't using this method, is very danger
    public function __import_router_tree(array $router_tree, array $router_error, array $router_hooks) {
        $this->_tree = $router_tree;
        $this->_error = $router_error;
        $this->_hooks = $router_hooks;
    }

    public function __export_router_tree() {
        return array($this->_tree, $this->_error, $this->_hooks);
    }

    # import router table
    public function import_router_table($route_classes) {
        $error_routes = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Error') === 0) {
                return true;
            }
        });
        $hook_routes = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Hook') === 0) {
                return true;
            }
        });
        $path_route = array_filter($route_classes, function($class_name) {
            if (strpos($class_name, 'Route') === 0) {
                return true;
            }
        });

        $this->_parser_error_route($error_routes);
        $this->_parser_hook_route($hook_routes);
        $this->_parser_path_route($path_route);
    }

    # router entry point
    public function entry($request_method = null, $request_url = null) {
        $request_method = strtoupper($request_method ? $request_method : $this->_variable['request_method']);
        $request_url = $request_url ? $request_url : $this->_variable['current_url'];

        $this->_callback_params = array(
            '__url__' => $request_url,
            '__method__' => $request_method,
        );

        list($callback, $hooks) = $this->_reslove($request_method, $request_url, $this->_callback_params);

        # raise error
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

       # check hook return value is true?
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

    public function emit_error($error_code/* ... other args ... */) {
        $error_code = intval($error_code);
        Here_Request::set_http_code($error_code);

        if (!array_key_exists($error_code, $this->_error)) {
            throw new Exception('error handler not found', 1996);
        }

        $args = func_get_args();
        if (call_user_func($this->_error[$error_code], $args[1]) || _here_emit_error_after_exit_) {
            exit;
        }
    }

    public function request_method() {
        return $this->_variable['request_method'];
    }

    public function current_url() {
        return $this->_variable['current_url'];
    }

    private function _emit_hook($hook_name, $params) {
        return $this->_hooks[$hook_name]($params);
    }

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
    }

    private function _create_error_handler($error, $handler) {
        $this->_error[$error] = $handler;
    }

    private function _create_hook_handler($hook_name, $handler) {
        $this->_hooks[$hook_name] = $handler;
    }

    private function _reslove($request_method, $request_url, &$params) {
        if (!array_key_exists($request_method, $this->_tree)) {
            $params['errno'] = '404';
            $params['error'] = 'router not found this request method';

            return array(null, null);
        }

        $trim_url = trim($request_url, self::$URL_SEPARATOR);
        $nodes = explode(self::$URL_SEPARATOR, str_replace('.', self::$URL_SEPARATOR, $trim_url));

        return $this->_search_router($this->_tree[$request_method], $nodes, $params);
    }

    private function _search_router($tree, $nodes, &$params) {
        $require_node = array_shift($nodes);

        # search complete
        if ($require_node == null) {
            if (array_key_exists(self::$HANDLE, $tree)) {
                return array($tree[self::$HANDLE][self::$CALLBACK], $tree[self::$HANDLE][self::$HOOK]);
            } else {
                $params['errno'] = '404';
                $params['error'] = 'router handler not defined';

                return array(null, null);
            }
        }

        # First, full matching router
        foreach ($tree as $node => $value) {
            if ($node == $require_node) {
                return $this->_search_router($tree[$node], $nodes, $params);
            }
        }

        # no variable routing
        if (empty($tree[self::$RE_ROUTER]) && empty($tree[self::$VAR_ROUTER])) {
            $params['errno'] = '404';
            $params['error'] = 'no matching router';

            return array(null, null);
        }

        # second, re matching routing
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

        if (empty($tree[self::$VAR_ROUTER])) {
            $params['errno'] = '404';
            $params['error'] = 'no var-matching routing';
        } else {
            $var_node = $tree[self::$VAR_ROUTER];
            foreach ($var_node as $key => $val) {
                $pos = strpos($key, ':');
                if ($pos) {
                    if (array_key_exists($key[$pos + 1], $this->_validate) && !call_user_func('ctype_' . $this->_validate[$key[$pos + 1]], $require_node)) {
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

        return array(null, null);
    }

    private function _parser_error_route($error_route_list) {
        foreach ($error_route_list as $error_route) {
            $route_class = new $error_route();
            $error_code = $route_class->errno();

            $this->_create_error_handler($error_code, array($route_class, 'entry_point'));
        }
    }

    private function _parser_hook_route($hook_route_list) {
        foreach ($hook_route_list as $hook_route) {
            $route_class = new $hook_route();
            $hook_name = $route_class->hook_name();

            $this->_create_hook_handler($hook_name, array($route_class, 'entry_point'));
        }
    }

    private function _parser_path_route($path_route_list) {
        foreach ($path_route_list as $path_route) {
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

    # variable router match flag
    private static $VAR_ROUTER = '$';

    # re match node
    private static $RE_ROUTER = '@';

    # callback node
    private static $CALLBACK = '__cb__';

    # hook node
    private static $HOOK = '__hk__';
}
