<?php
/**
 * BloggerEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger;
use Here\Lib\Config\ConfigRepository;
use Here\Lib\Environment\EnvironmentOverrideError;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Utils\Interfaces\InitializerInterface;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Stream\OStream\Client\Response;


/**
 * Class BloggerEnvironment
 * @package Here\App\Blogger
 */
final class BloggerEnvironment implements InitializerInterface {
    /**
     * initializing blogger environment
     */
    final public static function init(): void {
        // response environment
        Response::init();
        // Gl0balException environment
        GlobalExceptionHandler::init();
    }

    /**
     * @param string $config
     */
    final public static function init_config(string $config): void {
        $config_object = ConfigRepository::get_config($config);

        try {
            foreach ($config_object->get_item('environment', array()) as $key => $value) {
                GlobalEnvironment::set_user_env($key, $value);
            }

            foreach ($config_object->get_item('router', array()) as $key => $value) {
                GlobalEnvironment::set_user_env($key, $value);
            }
        } catch (EnvironmentOverrideError $e) {}
    }
}
