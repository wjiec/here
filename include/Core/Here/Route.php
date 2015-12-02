<?php
class Route {
    private $_hook;
    private $_error;
    private $_tree;
    
    const SEPARATOR = '/';
    
    private function createNode() {
    }
    public function __call($name, $args) {
        if (in_array($name, array('get', 'post'))) { // 路径匹配, 路由
            array_unshift($args, strtoupper($name));
            echo '';
        }
        if (in_array($name, array('error', 'hook'))) { // 钩子和错误处理
            $key = array_shift($args);
            $attr = '_' . $name;
            
            if (($attr = '_'. $name) && isset($args[0]) && is_callable($args[0])) {
                $this->{$attr}[$key] = $args[0];
            } else if (isset($this->{$attr}[$key]) && is_callable($this->{$attr}[$key])) {
                return call_user_func_array($this->{$attr}[$key], $args);
            } else {
                return ($name == 'error') ? trigger_error("\"{$key}\" not defined to handler error: {$args[0]}") : $args[0];
            }
        }
        
        return $this;
    }
}
