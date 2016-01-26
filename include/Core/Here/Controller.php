<?php
/**
 * @author ShadowMan 
 * @package Controller
 */
class Controller {
    private static $_include_path = 'include/Core/Controller/';
    private static $_class_perfix = 'Controller_';

    public static function __callstatic($controller, $args) {
        $controller = ucfirst($controller);
        if (is_file(self::$_include_path . $controller . '.php')) {
            $action = array_shift($args);
            // TODO : output required htmlentities
            if (!class_exists(self::$_class_perfix . $controller)) {
                throw new Exception("CLASS<" . self::$_class_perfix . $controller . "> NOT FOUND");
            }
            if (!is_callable([self::$_class_perfix . $controller, $action])) {
                throw new Exception(self::__class_prefix . $controller . "::{$action} NOT FOUND");
            }
            return call_user_func(self::$_class_perfix . $controller . "::" . $action);
        } else {
            throw new Exception("CONTROLLER<{$controller}> NOT FOUND");
        }
    }
}
?>