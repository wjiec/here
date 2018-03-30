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
use Here\Lib\Cache\CacheManager;
use Here\Lib\Config\ConfigRepository;
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
        GlobalEnvironment::set_user_env(UserEnvironment::ENV_DEBUG_MODE, 'on');
    }

    /**
     * @routerChannel
     * @addMiddleware enable_debug
     * @addMethods get
     * @addUrl /debug
     */
    final public function debug(): void {
        $cache = new CacheManager(ConfigRepository::get_cache());

        Response::debug_output($cache);
    }
}
