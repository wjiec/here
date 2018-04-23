<?php
/**
 * UserCollector.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Router;
use Here\Config\Constant\UserEnvironment;
use Here\Config\Model\User;
use Here\Lib\Environment\EnvironmentOverrideError;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Router\Collector\SysRouterCollector;


/**
 * Class UserCollector
 * @package Here\Config\Router
 */
final class UserCollector extends SysRouterCollector {
    /**
     * @routerMiddleware
     */
    final public function enable_debug(): void {
        try {
            GlobalEnvironment::set_user_env(UserEnvironment::ENV_DEBUG_MODE, 'on');
        } catch (EnvironmentOverrideError $e) {}
    }

    /**
     * @routerChannel
     * @addMiddleware enable_debug
     * @addMethods get
     * @addUrl /debug
     */
    final public function debug(): void {
        echo '<pre>';

//        $user = new User();
//        $user->name = 'Jayson Wang';
//        $user->email = 'shadowman@shellboot.com';
//        $user->persistent();
//        var_dump($user);

        $connection = new \mysqli('mysql', 'root', 'root');
        var_dump($connection);
        var_dump($connection->get_server_info());
    }
}
