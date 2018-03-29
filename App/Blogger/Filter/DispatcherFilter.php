<?php
/**
 * DispatcherFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter;
use Here\Config\Constant\SysEnvironment;
use Here\Config\Router\UserCollector;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Router\Dispatcher;
use Here\Lib\Router\RouterRequest;


/**
 * Class DispatcherFilter
 * @package Here\App\Blogger\Filter
 */
final class DispatcherFilter extends FilterChainProxyBase {
    /**
     * 1. create `UserCollector` and parse it
     * 2. create `Dispatcher` to find channel
     * 3. run channel and middleware if exists
     */
    final public function do_filter(): void {
        /* create `Dispatcher` load `UserCollector` */
        $dispatcher = new Dispatcher(new UserCollector());

        /* find channel by user request method and uri */
        $dispatcher->dispatch(RouterRequest::request_method(), RouterRequest::request_uri());

        $this->next();
    }
}
