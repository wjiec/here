<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Options extends Abstract_Widget {
    /**
     * reload method
     * 
     * @see Abstract_Widget::start()
     */
    public function start() {
        $optionDb = new Db();

        $optionDb->query($optionDb->select()->from('table.options')->where('for', Db::OP_EQUAL, '0'));
        $this->import($optionDb->fetchAll(), true);

        return $this;
    }

    public function __get($key) {
        return $this->_config->{$key};
    }

    public function __call($name, $args) {
        if ($this->_config->{$name} == null) {
            if (is_string($default = array_shift($args))) {
                echo $default;
            } else {
                throw new Exception('Default args is not except a String');
            }
        } else {
            echo $this->_config->{$name};
        }
    }

    public function output($key) {
        echo htmlspecialchars(($this->_config->{$key}) ? $this->_config->{$key} : null);
    }

    public function push($key, $val) {
        $this->_config->{$key} = $val;
    }

    

    public function earse($key) {
        $this->_config->earse($key);
    }
}

?>