<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Options extends Abstract_Widget {
    private $_options = null;

    public function start() {
        $optionDb = new Db();

        $optionDb->query($optionDb->select()->from('table.options')->where('for', Db::OP_EQUAL, '0'));
        $this->generate($optionDb->fetchAll());
    }

    public function generate($rows) {
        $this->_options = Config::factory(array());

        foreach ($rows as $row) {
            $this->_options->{$row['name']} = $row['value'];
        }
    }

    public function export() {
        return $this->_options;
    }
}

?>