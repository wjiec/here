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
use Here\Lib\Cache\Data\DataType\Set\SetValue;
use Here\Lib\Environment\EnvironmentOverrideError;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Router\Collector\SysRouterCollector;
use Here\Lib\Stream\OStream\Client\Response;


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
        $set = new SetValue('s1');
        Response::debug_output($set->get_value());

        $set->assign(array('a', 'b', 'c', 'd', 'e'));
        Response::debug_output($set->get_value());

        Response::debug_output($set->exists('d'));

        $set->remove('a', 'c');
        Response::debug_output($set->get_value());

        $set->add('1', '2', '3');
        Response::debug_output($set->get_value());

        Response::debug_output($set->random_cat());
        Response::debug_output($set->random_pop());
        Response::debug_output($set->get_value());

        $set2 = new SetValue('s2');
        $set2->assign(array('1', '2', 'asd'));

        Response::debug_output($set->inter($set2));
        Response::debug_output($set->union($set2));
        Response::debug_output($set->diff($set2));
    }
}
