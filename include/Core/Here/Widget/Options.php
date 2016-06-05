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