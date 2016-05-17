<?php
/**
 * @author ShadowMan 
 * @package Core.Router
 */
// XXX Static Router Class?
class Router {
    private $_hook;
    private $_error;
    private $_tree;
    private $_check = ['A' => 'alnum', 'a' => 'alpha', 'd' => 'digit', 'l' => 'lower', 'u' => 'upper'];

    private static $SEPARATOR = '/';
    private static $HANDLE    = '$$';
    private static $VARPATH   = '$';
    private static $CALLBACK  = '__cb__';
    private static $HOOK      = '__hk__';
    private static $EXCEPTION = '__ep__';

    public function __construct() {
        $this->_error = array();
        $this->_hook  = array();
        $this->_tree  = array();
    }

    public function __call($name, $args) {
        if (in_array($name, array('get', 'post', 'put', 'patch', 'delete'))) {
            array_unshift($args, strtoupper($name));
            call_user_func_array('self::match', $args);
        }
        if (in_array($name, array('error', 'hook'))) {
            $key = array_shift($args);
            $member = '_' . $name;
            if (isset($args[0]) && is_callable($args[0])) {
                $this->{$member}[$key] = $args[0];
            } else if (isset($this->{$member}[$key]) && is_callable($this->{$member}[$key])) {
                return call_user_func_array($this->{$member}[$key], $args);
            } else {
            }
        }
        return $this;
    }

    public function execute($params = array(), $method = null, $path = null) {
        $method = strtoupper($method ? $method : $_SERVER['REQUEST_METHOD']);
        $params['__path__'] = $path ? $path : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim($params['__path__'], self::$SEPARATOR);

        list($callback, $hook) = self::resolve($method, $path, $params);
        if ($hook && !empty($hook)) {
            foreach ($hook as $h) {
                $this->hook($h, $params);
            }
        }
        if (!is_callable($callback)) {
            if (isset($params[self::$EXCEPTION])) {
                $this->{key($params[self::$EXCEPTION])}(current($params[self::$EXCEPTION]), $params);
            }
        } else {
            call_user_func_array($callback, [$params]);
        }
    }

    public function match($method = array(), $path = array(), $callback = null, $hook = null) {
        if (!is_array($method)) {
            $method = [ $method ];
        }
        if (!is_array($path)) {
            $path = [ $path ];
        }
        foreach ($method as $m){
            $m = strtoupper($m);
            if (!array_key_exists($m, $this->_tree)) {
                $this->_tree[$m] = array();
            }
            foreach ($path as $p) {
                if (!is_string($p)) {
                    throw new Exception("Route Error");
                }
                $nodes = explode(self::$SEPARATOR, str_replace('.', self::$SEPARATOR, trim($p, self::$SEPARATOR)));
                $this->createNode($this->_tree[$m], $nodes, $callback, $hook);
            }
        }
        return $this;
    }

    private function createNode(&$tree, $nodes, $callback, $hook) {
        $currentNode = array_shift($nodes);
        if (!array_key_exists(self::$VARPATH, $tree)) {
            $tree[self::$VARPATH] = array();
        }
        if ($currentNode && $currentNode[0] == self::$VARPATH) {
            if (!isset($tree[self::$VARPATH][substr($currentNode, 1)])) {
                $tree[self::$VARPATH][substr($currentNode, 1)] = array();
            }
            return self::createNode($tree[self::$VARPATH][substr($currentNode, 1)], $nodes, $callback, $hook);
        } else {
            if ($currentNode && !array_key_exists($currentNode, $tree)) {
                $tree[$currentNode] = array();
            }
        }

        if ($currentNode) {
            return self::createNode($tree[$currentNode], $nodes, $callback, $hook);
        }

        $tree[self::$HANDLE] = [ self::$CALLBACK => $callback, self::$HOOK => array() ];
        if (is_array($hook)) {
            $tree[self::$HANDLE][self::$HOOK] = array_merge($tree[self::$HANDLE][self::$HOOK], $hook);
        } else if (is_string($hook)) {
            $tree[self::$HANDLE][self::$HOOK][] = $hook;
        }
    }

    private function resolve($method, $path, &$params) {
        if (!array_key_exists($method, $this->_tree)) {
            $params = array_merge($params, [self::$EXCEPTION => ['error' => '404', 'message' => 'METHOD NOT FOUND']]);
            return [null, null];
        }
        $nodes = explode(self::$SEPARATOR, str_replace('.', self::$SEPARATOR, $path));
        return self::_find($this->_tree[$method], $nodes, $params);
    }

    private function _find(&$tree, $nodes, &$params) {
        $need = array_shift($nodes);
        if (empty($need)) {
            if (array_key_exists(self::$HANDLE, $tree)) {
                return [$tree[self::$HANDLE][self::$CALLBACK], $tree[self::$HANDLE][self::$HOOK]];
            } else {
                $params = array_merge($params, [self::$EXCEPTION => ['error' => '404', 'message' => 'HANDLE NOT FOUND']]);
                return [null, null];
            }
        }
        foreach ($tree as $node => $value) {
            if ($node == self::$HANDLE || $node == self::$VARPATH) { continue; }
            if ($need == $node) {
                return $this->_find($tree[$node], $nodes, $params);
            }
        }

        if (empty($tree[self::$VARPATH])) {
            $params = array_merge($params, [self::$EXCEPTION => ['error' => '404', 'message' => 'PATH NOT FOUND']]);
            return [null, null];
        } else {
            $match = $tree[self::$VARPATH];
            foreach ($match as $key => $val) {
                if ($pos = strpos($key, '\\')) {
                    if (array_key_exists($key[$pos + 1], $this->_check) && !call_user_func('ctype_' . $this->_check[$key[$pos + 1]], $need)) {
                        $params = array_merge($params, [self::$EXCEPTION => ['error' => '404', 'message' => 'VALIDATE FAILURE']]);
                        continue;
                    } else {
                        unset($params[self::$EXCEPTION]);
                    }
                }
                $params[$pos ? substr($key, 0, $pos) : $key] = $need;
                list($c, $h) = $this->_find($match[$key], $nodes, $params);

                if ($c && is_callable($c)) {
                    return [$c, $h];
                }
                unset($params[$key]);
            }
        }
    }
}
