<?php
/**
 * @author ShadowMan
 * @package here::Config
 */
class Config {
    /**
     * Current Config
     * @var array
     */
    private $_config;

    /**
     * 
     * @param array $config
     */
    public function __construct($config) {
        $this->_config = array();

        if (empty($config)) {
            return;
        }
        if (is_string($config)) {
            parse_str($config, $params);
        } else {
            $params = $config;
        }
        $this->_config = array_merge($this->_config, $params);
    }

    /**
     * 
     * @param array $config
     * @param string $core
     */
    public static function factory($config = array(), $core = null) {
        return new Config($config);
    }

    public function __call($name, $args) {
        echo (isset($this->_config[$key])) ? $this->_config[$name] : '';
    }

    public function __get($key) {
        return (isset($this->_config[$key])) ? $this->_config[$key] : null;
    }

    public function __set($key, $val) {
        return $this->_config[$key] = $val;
    }

    public function __isset($key) {
        return isset($this->_config[$key]);
    }

    public function __toString() {
        return serialize($this->_config);
    }

    public function contains($key) {
        return array_key_exists($key, $this->_config);
    }

    public function import($config, $earse = false) {
        if (is_array($config)) {
            if ($earse == true) {
                $this->_config = $config;
            } else {
                $this->_config = array_merge($this->_config, $config);
            }
        }
    }

    public static function export(Config $config) {
        return unserialize($config->__toString());
    }

    public function earse($key) {
        if (isset($this->_config[$key])) {
            unset($this->_config[$key]);
        }
    }
}
?>