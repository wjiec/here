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
use Here\Lib\Database\DatabaseHelper;
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
        /* @var User $user */
        $user = DatabaseHelper::create_model(User::class);
        var_dump($user);

        $user->update_at = time();
        $user->create_at = time();
        var_dump($user);
    }
}
