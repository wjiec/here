<?php
/**
 * @author ShadowMan
 * @package Core.Router
 */
class Router {
    private $_hook;
    private $_error;
    private $_tree;
    private $_check = ['A' => 'alnum', 'a' => 'alpha', 'd' => 'digit', 'l' => 'lower', 'u' => 'upper'];

    const SEPARATOR = '/';
    const HANDLE = '$$';
    const VARIABLE = '$';

    const CALLBACK = 'cb';
    const HOOK = 'hook';
    const STATUS = 'status';

    // TODO: params convert to static member 
    public function __construct() {
        $this->_error = [];
        $this->_hook  = [];
        $this->_tree  = [];
    }

    public function __call($name, $args) {
        if (in_array($name, array('get', 'post', 'put', 'patch', 'delete'))) {
            array_unshift($args, strtoupper($name));
            call_user_func_array('self::match', $args);
        }
        if (in_array($name, array('error', 'hook'))) {
            $key  = array_shift($args);
            $member = '_'. $name;
            if (isset($args[0]) && is_callable($args[0])) {
                $this->{$member}[$key] = $args[0];
            } else if (isset($this->{$member}[$key]) && is_callable($this->{$member}[$key])) {
                return call_user_func_array($this->{$member}[$key], $args);
            } else {
                // ...
            }
        }
        return $this;
    }

    public function execute($params = [], $method = null, $path = null) {
        $method = strtoupper($method ? $method : $_SERVER['REQUEST_METHOD']);
        $params['_path'] = $path ? $path : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim($params['_path'], self::SEPARATOR);

        $this->hook('will', $params);
        list($callback, $hook) = self::resolve($method, $path, $params);
        $this->hook('did', $params);

        $params['_handle'] = ['_callback' => $callback, '_hook' => $hook];
        if ($hook && !empty($hook)) {
            foreach ($hook as $h) {
                $this->hook($h, $params);
            }
        }
        if (!is_callable($callback)) {
            if (isset($params[self::STATUS])) {
                $this->{key($params[self::STATUS])}(current($params[self::STATUS]), $params);
            }
        } else {
            call_user_func_array($callback, [$params]);
        }
    }

    public function match($method = [], $path = [], $callback = null, $hook = null) {
        if (!is_array($method)) {
            $method = [ $method ];
        }
        if (!is_array($path)) {
            $path = [ $path ];
        }
        foreach($method as $m){
            $m = strtoupper($m);
            if (!array_key_exists($m, $this->_tree)) {
                $this->_tree[$m] = [];
            }
            foreach ($path as $p) {
                if (!is_string($p)) {
                    throw new Exception("Route Error");
                }
                $nodes = explode(self::SEPARATOR, str_replace('.', self::SEPARATOR, trim($p, self::SEPARATOR)));
                $this->createNode($this->_tree[$m], $nodes, $callback, $hook);
            }
        }
        return $this;
    }

    private function createNode(&$tree, $nodes, $callback, $hook) {
        $currentNode = array_shift($nodes);
        if (!array_key_exists(self::VARIABLE, $tree)) {
            $tree[self::VARIABLE] = [];
        }
        if ($currentNode && $currentNode[0] == self::VARIABLE) {
            if (!isset($tree[self::VARIABLE][substr($currentNode, 1)])) {
                $tree[self::VARIABLE][substr($currentNode, 1)] = [];
            }
            return self::createNode($tree[self::VARIABLE][substr($currentNode, 1)], $nodes, $callback, $hook);
        } else {
            if ($currentNode && !array_key_exists($currentNode, $tree)) {
                $tree[$currentNode] = [];
            }
        }

        if ($currentNode) { // create next node
            return self::createNode($tree[$currentNode], $nodes, $callback, $hook);
        }

        $tree[self::HANDLE] = [self::CALLBACK => $callback, self::HOOK => []];
        if (is_array($hook)) {
            $tree[self::HANDLE]['hook'] = array_merge($tree[self::HANDLE]['hook'], $hook);
        } else if ($hook) {
            $tree[self::HANDLE]['hook'][] = $hook;
        }
    }

    private function resolve($method, $path, &$params) {
        if (!array_key_exists($method, $this->_tree)) {
            $params = array_merge($params, [self::STATUS => ['error' => '404', 'message' => 'METHOD NOT FOUND']]);
            return [null, null];
        }
        $nodes = explode(self::SEPARATOR, str_replace('.', self::SEPARATOR, $path));
        return self::__find($this->_tree[$method], $nodes, $params);
    }

    private function __find(&$tree, $nodes, &$params) {
        $need = array_shift($nodes);
        if (empty($need)) {
            if (array_key_exists(self::HANDLE, $tree)) {
                return [$tree[self::HANDLE][self::CALLBACK], $tree[self::HANDLE][self::HOOK]];
            } else {
                $params = array_merge($params, [self::STATUS => ['error' => '404', 'message' => 'HANDLE NOT FOUND']]);
                return [null, null];
            }
        }
        foreach ($tree as $node => $value) {
            if ($node == self::HANDLE || $node == self::VARIABLE) { continue; }
            if ($need == $node) {
                return $this->__find($tree[$node], $nodes, $params);
            }
        }

        if (empty($tree[self::VARIABLE])) {
            $params = array_merge($params, [self::STATUS => ['error' => '404', 'message' => 'PATH NOT FOUND']]);
            return [null, null];
        } else {
            $match = $tree[self::VARIABLE];
            foreach ($match as $key => $val) {
                if ($pos = strpos($key, '^')) {
                    if (array_key_exists($key[$pos + 1], $this->_check) && !call_user_func('ctype_' . $this->_check[$key[$pos + 1]], $need)) {
                        $params = array_merge($params, [self::STATUS => ['error' => '404', 'message' => 'VALIDATE FAILURE']]);
                        continue;
                    } else {
                        unset($params[self::STATUS]);
                    }
                }
                $params['_data'][$pos ? substr($key, 0, $pos) : $key] = $need;
                list($c, $h) = $this->__find($match[$key], $nodes, $params);

                if ($c && is_callable($c)) {
                    return [$c, $h];
                }
                unset($params['_data'][$key]);
            }
        }
    }
}
