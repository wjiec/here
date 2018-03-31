<?php
/**
 * LoadConfigureFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter\Init;
use Here\Lib\Config\ConfigRepository;
use Here\Lib\Environment\EnvironmentOverrideError;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;


/**
 * Class LoadConfigureFilter
 * @package Here\App\Blogger\Filter
 */
final class LoadConfigureFilter extends FilterChainProxyBase {
    /**
     * load user configure and merge to `GlobalEnvironment`
     */
    final public function do_filter(): void {
        /**
         * @TODO from outside getting this parameter
         */
        $config_object = ConfigRepository::get_config('configure.json');

        try {
            /* environment segment */
            foreach ($config_object->get_config('environment', array()) as $key => $value) {
                GlobalEnvironment::set_user_env($key, $value);
            }

            /* router segment */
            foreach ($config_object->get_config('router', array()) as $key => $value) {
                GlobalEnvironment::set_user_env($key, $value);
            }
        } catch (EnvironmentOverrideError $e) {}

        /* exec next filter */
        $this->next();
    }
}
