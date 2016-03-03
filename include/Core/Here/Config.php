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

    public function __construct($config) {
        $this->_config = [];

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

    public static function factory($config, $core = null) {
        return new Config($config);
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

    public static function toString(Config $config) {
        return serialize($config->__toString());
    }

    public static function export(Config $config) {
        return unserialize($config->__toString());
    }
}

?>