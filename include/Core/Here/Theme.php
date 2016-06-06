<?php
/**
 * @author ShadowMan 
 * @package Theme
 */
class Theme {
    /**
     * theme name, default null
     * @access private
     * @var string
     */
    private static $_themeName = null;

    /**
     * default theme name
     * @access private
     * @var theme
     */
    private static $_defaultThemeName = 'default';

    /**
     * include theme path
     * @access private
     * @var string
     */
    private static $_themePath = 'include/Theme/';

    /**
     * error NO.
     * @access public
     * @var int
     */
    public static $errno = 0;

    /**
     * error message
     * @access public
     * @var string
     */
    public static $error = null;

    /**
     * params
     * @access private
     * @var array
     */
    private static $_params = null;

    public static function setTheme($theme) {
        if (!($theme && is_dir(self::$_themePath . $theme))) {
            throw new Exception('Invalid Parameter');
        }
        self::$_themeName = $theme;
    }

    public static function __callStatic($name, $args) {
        self::$_params = $args;
        if (self::$_themeName) {
            $file = self::$_themePath . self::$_themeName . '/' . trim($name, '_') . '.php';
        } else {
            $file = self::$_themePath . self::$_defaultThemeName . '/' . trim($name, '_') . '.php';
        }

        self::$errno = (isset(self::$_params[0]) && ctype_digit(self::$_params[0])) ? intval(self::$_params[0]) : 0;
        self::$error = (isset(self::$_params[1]) && is_string(self::$_params[1])) ? self::$_params[1] : null;
        if (is_file($file)) {
            include $file;
        } else {
            Core::router()->error('404', 'File Not Found'); // 451? hhh
        }

        exit;
    }
}

?>