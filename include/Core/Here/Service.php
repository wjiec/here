<?php
/**
 * @author ShadowMan 
 * @package Controller
 */
class Service {
    private static $_include_path = 'include/Core/Service/';
    private static $_class_perfix = 'Service_';

    public static function __callstatic($service, $args) {
        $service = ucfirst($service);
        if (is_file(self::$_include_path . $service . '.php')) {
            $action = array_shift($args);
            // TODO : output required htmlentities
            if (!class_exists(self::$_class_perfix . $service)) {
                throw new Exception("CLASS<" . self::$_class_perfix . $service . "> NOT FOUND", 404);
            }
            if (!is_callable([self::$_class_perfix . $service, $action])) {
                throw new Exception(self::__class_prefix . $service . "::{$action} NOT FOUND");
            }
            return call_user_func(self::$_class_perfix . $service . "::" . $action);
        } else {
            throw new Exception("SERVICE&lt;{$service}&gt; NOT FOUND", '404');
        }
    }
}
?>