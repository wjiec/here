<?php
/**
 * @author ShadowMan
 * @package Here.Plugin.Executor
 */

class Plugins_Exector {
    private $_binds = array();

    private $_instance = null;

    private $_module = null;

    private $_position = null;

    private $_params = array();

    /**
     * construct function
     * @param string $name
     */
    public function __construct($module, $position, $function) {
        $this->_module = $module;
        $this->_position = $position;

        if (is_callable($function)) {
            $this->_instance = $function;
        }
    }

    public static function factory($module, $position, $method) {
        return new Plugins_Exector($module, $position, $method);
    }

    public function execute() {
        if ($this->_module && $this->_position && $this->_instance) {
            return call_user_func_array($this->_instance, $this->_params);
        } else {
            throw new Exception('Cannt defined callback', -1);
        }
    }

    public function args($params) {
        if (is_array($params)) {
            $this->_params = $params;
        }
        return $this;
    }
}

?>