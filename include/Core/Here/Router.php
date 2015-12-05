<?php
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

    public function __construct() {
        $this->_error = [];
        $this->_hook  = [];
        $this->_tree  = [];
    }

    public function __call($name, $args) {
        if (in_array($name, array('get', 'post'))) {
            array_unshift($args, strtoupper($name));
            call_user_func_array('self::initNode', $args);
        }
        if (in_array($name, array('error', 'hook'))) { // 钩子和错误处理
            $key  = array_shift($args); // _error | _hook 中的键, 表示一个错误或者一个钩子，值为需要触发的方法
            $member = '_'. $name; // _error($this->_error) & _hook($this->_hook)

            if (isset($args[0]) && is_callable($args[0])) { // $argv[0] -> callback, 回调方法
                $this->{$member}[$key] = $args[0]; // 设置回调
            } else if (isset($this->{$member}[$key]) && is_callable($this->{$member}[$key])) { // 如果只传入 key(和不是一个可调用结构的参数), 检查这个键是否存在, 存在就调用这个回调函数
                return call_user_func_array($this->{$member}[$key], $args);
            } else { // 调用错误, 即不是设置对应 error | hook 的回调函数，也不是触发相应 error | hook 的
                // error & hook not found
            }
        }
        return $this;
    }

    public function execute($method = null, $path = null, $params = []) {
        $method = strtoupper($method ? $method : $_SERVER['REQUEST_METHOD']);
        $params['_path'] = $path ? $path : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $path = trim($params['_path'], self::SEPARATOR);
        
        $this->hook('will', $params);
        list($callback, $hook) = self::resolve($method, $path, $params);
        $this->hook('did', $params);
        
        $params['_handle'] = ['_callback' => $callback, '_hook' => $hook];
        $params['this'] = $this;
        
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

    private function initNode($method, $path, $callback, $hook = null) {
        $nodes = explode(self::SEPARATOR, str_replace('.', self::SEPARATOR, trim($path, self::SEPARATOR)));
        if (!is_array($method)) {
            $method = [ $method ];
        }
        foreach($method as $m){
            if (!array_key_exists($m, $this->_tree)) { // 如果在 _tree 中， $method 键值对不存在，就创建这个键值对。值为array
                $this->_tree[$m] = [];
            }
            $this->createNode($this->_tree[$m], $nodes, $callback, $hook);
        }
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

        $tree[self::HANDLE] = [ self::CALLBACK => $callback, self::HOOK => [] ];
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
                $params['_data'][substr($key, 0, $pos)] = $need;
                list($c, $h) = $this->__find($match[$key], $nodes, $params);
                
                if ($c && is_callable($c)) {
                    return [$c, $h];
                }
                unset($params['_data'][$key]);
            }
        }
    }
}
