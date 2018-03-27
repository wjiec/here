<?php
/**
 * Blogger.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger;
use Here\App\ApplicationInterface;
use Here\App\Blogger\Filter\AutoCommitFilter;
use Here\App\Blogger\Filter\DispatcherFilter;
use Here\App\Blogger\Filter\Init\BloggerComponentInit;
use Here\App\Blogger\Filter\Init\LoadConfigureFilter;
use Here\App\Blogger\Filter\RobotRejectFilter;
use Here\Config\Constant\SysConstant;
use Here\Config\Constant\UserEnvironment;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Extension\FilterChain\FilterChainContainer;
use Here\Lib\Utils\Filter\Validator\TrueValidator;


/**
 * Class Blogger
 * @package Here\App
 */
final class Blogger implements ApplicationInterface{
    /**
     * @var FilterChainContainer
     */
    private $_filter_chain;

    /**
     * Blogger constructor.
     */
    final public function __construct() {
        /* initializing component by `FilterChain` */
        $this->init_components();

        /* register all filter chain */
        $this->register_all_filter();
    }

    /**
     * start blogger service
     */
    final public function start_service(): void {
        $this->_filter_chain->start_filter();
    }

    /**
     * @return string
     */
    final public static function get_version(): string {
        return join('.', SysConstant::HERE_VERSION);
    }

    /**
     * initializing all components and load configure based by `FilterChain`
     */
    final private function init_components(): void {
        /* filter container */
        $container = new FilterChainContainer();

        /* initializing all components */
        $container->register_filter(new BloggerComponentInit());

        /* load configure and push it to `GlobalEnvironment` */
        $container->register_filter(new LoadConfigureFilter());

        /* startup container */
        $container->start_filter();
    }

    /**
     * register all filter based on environments setting
     */
    final private function register_all_filter(): void {
        $this->_filter_chain = new FilterChainContainer();

        /* register `AutoCommit` filter when it enabled */
        if (TrueValidator::filter(GlobalEnvironment::get_user_env(UserEnvironment::ENV_AUTO_COMMIT))) {
            $this->_filter_chain->register_filter(new AutoCommitFilter());
        }

        /* @TODO HTML escape filter */

        /* register `RobotReject` filter */
        $this->_filter_chain->register_filter(new RobotRejectFilter());

        /* register dispatcher */
        $this->_filter_chain->register_filter(new DispatcherFilter());
    }
}
