<?php
class Route {
    private $_hook;
    private $_error;
    private $_tree;

    const SEPARATOR = '/';
    const HANDLE = '$$';

    const CALLBACK = 'cb';
    const HOOK = 'hook';
    
    public function __construct() {
        $this->_error = [];
        $this->_hook  = [];
        $this->_tree  = [];
    }

    public function __call($name, $args) {
        if (in_array($name, array('get', 'post'))) {
            array_unshift($args, strtoupper($name));
            call_user_func_array('self::createNode', $args);
        }
        if (in_array($name, array('error', 'hook'))) { // 钩子和错误处理
            $key  = array_shift($args); // _error | _hook 中的键, 表示一个错误或者一个钩子，值为需要触发的方法
            $member = '_'. $name; // _error($this->_error) & _hook($this->_hook)
    
            if (isset($args[0]) && is_callable($args[0])) { // $argv[0] -> callback, 回调方法
                $this->{$member}[$key] = $args[0]; // 设置回调
            } else if (isset($this->{$member}[$key]) && is_callable($this->{$member}[$key])) { // 如果只传入 key(和不是一个可调用结构的参数), 检查这个键是否存在, 存在就调用这个回调函数
                return call_user_func_array($this->{$member}[$key], $args);
            } else { // 调用错误, 即不是设置对应 error | hook 的回调函数，也不是触发相应 error | hook 的
                return ($name == 'error') ? trigger_error("`{$name}`->\"{$key}\": {$args[0]}") : $args[0]; // set_error_handler($error_handler);
            }
        }

        return $this;
    }
    
    public function execute($method = null, $path = null, $params = []) {
        $method = $method ? $method : $_SERVER['REQUEST_METHOD'];
        $path = trim($path ? $path : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), self::SEPARATOR);
        
        list($callback, $hook, $params) = self::resolve($method, $path, $params);
        if (!is_callable($callback)) {
            if (empty($params[0])) {
                echo $params[0];
            } else {
                $this->error('404');
            }
        } else {
            call_user_func_array($callback, $params);
        }
    }
    
    private function createNode($method, $path, $callback, $hook = null) {
        $nodes = explode(self::SEPARATOR, str_replace('.', self::SEPARATOR, trim($path, self::SEPARATOR)));
        if (!is_array($method)) {
            $method = [ $method ];
        }
        foreach($method as $m){
            if (!array_key_exists($m, $this->_tree)) { // 如果在 _tree 中， $method 键值对不存在，就创建这个键值对。值为array
                $this->_tree[$m] = [];
            }
            $this->match_one_path($this->_tree[$m], $nodes, $callback, $hook);
        }
    }

    private function match_one_path(&$tree, $nodes, $callback, $hook) {
        $currentNode = array_shift($nodes);
        if ($currentNode && !array_key_exists($currentNode, $tree)) {
            $tree[$currentNode] = [];
        }
        
        if ($currentNode) { // create next node
            return self::match_one_path($tree[$currentNode], $nodes, $callback, $hook);
        }

        $tree[self::HANDLE] = [ self::CALLBACK => $callback, self::HOOK => [] ];
        if (is_array($hook)) {
            foreach ($hook as $h) {
                array_push($tree[self::HANDLE]['hook'], $h);
            }
        } else if ($hook) {
            array_push($tree[self::HANDLE]['hook'], $hook);
        }
    }
    
    private function resolve($method, $path, $params) {
        if (!array_key_exists($method, $this->_tree)) {
            return [null, null, ["METHOD \"{$method}\" NOT FOUND"]];
        }
        $nodes = explode(self::SEPARATOR, str_replace('.', self::SEPARATOR, $path));
        
        return self::__find($this->_tree[$method], $nodes, $params);
    }
    
    private function __find(&$tree, $nodes, $params) {
        $need = array_shift($nodes);
        
        if (empty($need)) {
            if (array_key_exists(self::HANDLE, $tree)) {
                return [$tree[self::HANDLE][self::CALLBACK], $tree[self::HANDLE][self::HOOK], $params];
            } else {
                return [null, null, ["\"HANDLE NOT FOUND\""]];
            }
        }
        foreach ($tree as $node => $value) {
            if ($node == self::HANDLE) { continue; }
            if ($node == $need) {
                return $this->__find($tree[$node], $nodes, $params);
            }
        }
        
        return [null, null, ["PATH NOT FOUND"]];
    }
}
