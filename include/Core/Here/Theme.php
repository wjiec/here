<?php
/**
 * @author ShadowMan 
 * @package Theme
 */
class Theme {
    # return with exit
    const RETURN_WITH_DIE = 1;

    # return with continue
    const RETURN_WITH_GON = 0;

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

    /**
     * site config
     * @access private
     * @var Config
     */
    private static $_config = null;

    public static function setTheme($theme) {
        if (!($theme && is_dir(self::$_themePath . $theme))) {
            throw new Exception('Invalid Parameter');
        }
        self::$_themeName = $theme;
    }

    /**
     * set config
     * @param array $config
     */
    public static function configSet(array $config) {
        if (is_array($config)) {
            self::$_config = Config::factory($config);
        }
    }

    public static function configGet() {
        if (self::$_config == null) {
            Theme::_404(1984, 'Missing Config.php File.', Theme::RETURN_WITH_DIE);
        } else {
            return self::$_config;
        }
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

        if (!isset($args[0]) || (isset($args[func_num_args()]) && $args[func_num_args()] == self::RETURN_WITH_DIE)) {
            exit;
        }
    }
}

?>