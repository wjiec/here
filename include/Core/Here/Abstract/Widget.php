<?php
/**
 *
 * @author ShadowMan
 */

class Abstract_Widget implements Interface_Widget {
    protected $_config;

//     static protected $_options;

    public function __construct($params = array()) {
        $this->_config = Config::factory($params);
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

//     public static function options(&$widget) {
//         if ($widget instanceof Widget_Options) {
//             self::$_options = $widget;
//         }
//     }

    /**
     * (non-PHPdoc)
     * 
     * @see Interface_Widget::start()
     *
     */
    public function start() {
        /* noop */
    }

    public function __get($key) {
        return $this->_config->{$key};
    }
}

?>