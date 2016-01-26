<?php
/**
 * @author ShadowMan 
 * @package Theme
 */
class Theme {
    private static $_theme = null;

    private static $_default_theme = 'default';
    private static $_base_path = 'include/Theme/';

    const GDIE = 1;
    const GLIVE = 0;

    public static function setTheme($theme) {
        if (!($theme && is_dir(self::$_base_path . $theme))) {
            throw new Exception('Invalid Parameter');
        }
        self::$_theme = $theme;
    }

    public static function __callStatic($name, $args) {
        if (self::$_theme) {
            $file = self::$_base_path . self::$_theme . '/' . trim($name, '_') . '.php';
        } else {
            $file = self::$_base_path . self::$_default_theme . '/' . trim($name, '_') . '.php';
        }

        if (is_file($file)) { @include $file; }
        else {
            Core::router()->error('404', 'File Not Found'); // 451? hhh
        }

        if (!isset($args[0]) || (isset($args[0]) && $args[0] == self::GDIE)) {
            exit;
        }
    }
}

?>