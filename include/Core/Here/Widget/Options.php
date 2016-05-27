<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Options extends Abstract_Widget {
    /**
     * store table.options record
     * 
     * @var Config
     */
    private $_options = null;

    /**
     * reload method
     * 
     * @see Abstract_Widget::start()
     */
    public function start() {
        $optionDb = new Db();

        $optionDb->query($optionDb->select()->from('table.options')->where('for', Db::OP_EQUAL, '0'));
        $this->generate($optionDb->fetchAll());
    }

    private function generate($rows) {
        $this->_options = Config::factory(array());

        foreach ($rows as $row) {
            $this->_options->{$row['name']} = $row['value'];
        }
    }

    public function export() {
        return $this->_options;
    }

    public function __get($key) {
        return $this->_options->{$key};
    }

    public function __set($key, $val) {
        $this->_options->{$key} = $val;
    }
}

?>