<?php
/**
 * @author ShadowMan 
 * @package Controller
 */
class Controller {
    const __include_path = 'include/Core/Controller/';
    const __class_prefix = 'Controller_';
    const _PHP  = '.php';

    public static function request($controller, $action, $params = null) {
        $controller = ucfirst($controller);
        if (file_exists(self::__include_path . $controller . self::_PHP) && !is_dir(self::__include_path . $controller . self::_PHP)) {
            if (!class_exists(self::__class_prefix . $controller)) {
                throw new Exception("CLASS<" . self::__class_prefix . $controller . "> NOT FOUND"); // htmlentities
            }
            if (!is_callable([self::__class_prefix . $controller, $action])) {
                throw new Exception(self::__class_prefix . $controller . "::{$action} NOT FOUND");
            }
            return call_user_func(self::__class_prefix . $controller . "::" . $action, $params);
        } else {
            throw new Exception("CONTROLLER<{$controller}> NOT FOUND");
        }
    }
}
?>