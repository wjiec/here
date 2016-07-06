<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Flags extends Abstract_Widget {
    public function start() {
        $this->_config->import(array(
            'ConfigLoaded' => false,
            'Developer'    => false,
            'Updateing'    => false,
            'UpdatePlugin' => false
        ));
    }

    public function reverse($flag) {
        return $this->assignment($flag, null);
    }

    public function enable($flag) {
        return $this->assignment($flag, true);
    }

    public function disable($flag) {
        return $this->assignment($flag, false);
    }

    public function flag($flag) {
        if ($this->_config->contains($flag)) {
            return $this->_config->$flag;
        }

        return null;
    }

    public function register($flag, $function) {
        if ($this->_config->contains($flag) && is_callable($function)) {
            // ... #TODO. Add This
        }
    }

    private function assignment($flag, $value) {
        if ($this->_config->contains($flag)) {
            $this->_config->$flag = $value === null ? !$this->_config->$flag : boolval($value);
        } else {
            return false;
        }

        return true;
    }

    public function debug() {
        var_dump($this->_config);
    }
}

?>