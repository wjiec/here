<?php
/**
 *
 * @author ShadowMan
 */

class Abstract_Widget implements Interface_Widget {
    /**
     * 
     * @var Config
     */
    protected $_config;

//     static protected $_options;

    public function __construct() {
        $this->_config = Config::factory();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Interface_Widget::start()
     *
     */
    public function start() {
        /* noop */
    }

    /**
     * 
     * @param array|Config $config
     * @param bool $fromDb
     */
    protected function import($config, $fromDb = false) {
        if (is_array($config) && $fromDb) {
            $tmpArray = array();

            foreach ($config as $row) {
                $tmpArray[$row['name']] = $row['value'];
            }

            $config = $tmpArray;
        }

        if ($config instanceof Config) {
            $this->_config = $config;
        } else if (is_array($config)) {
            $this->_config = Config::factory($config);
        }
    }

    public function __get($key) {
        return $this->_config->{$key};
    }
}

?>