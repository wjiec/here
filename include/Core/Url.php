<?php
class Core_Url {
    public static function __res($path) {
        return (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '' . $path;
    }
}