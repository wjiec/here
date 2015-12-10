<?php
/**
 * @author ShadowMan
 * @package Controller
 */
class Controller {
    const _path = 'include/Core/Controller/';
    const _pref = 'Controller_';
    const _PHP  = '.php';
    
    public static function request($controller, $action, $params = null) {
        if (file_exists(self::_path . $controller . self::_PHP) && !is_dir(self::_path . $controller . self::_PHP)) {
            if (!class_exists(self::_pref . ucfirst($controller))) {
                throw new Exception("CLASS NOT FOUND");
            }
            if (!is_callable([self::_pref . ucfirst($controller), $action])) {
                throw new Exception("METHOD NOT FOUND");
            }
            call_user_func(self::_pref . ucfirst($controller) . "::" . $action, $params);
        } else {
            throw new Exception("CONTROLLER NOT FOUND");
        }
    }
}

?>