<?php
class Route {
    private function match() {
    }
    public function __call($name, $args) {
        if (in_array($name, array('get', 'post'))) {
        } else if (in_array($name, array('hook', 'error'))) {
        }
    }
    public function run() {
    }
}
