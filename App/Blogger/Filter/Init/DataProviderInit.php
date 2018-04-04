<?php
/**
 * DataProviderInit.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter\Init;
use Here\Lib\Cache\CacheRepository;
use Here\Lib\Config\ConfigRepository;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;


/**
 * Class DataProviderInit
 * @package Here\App\Blogger\Filter\Init
 */
class DataProviderInit extends FilterChainProxyBase {
    /**
     * 1. init cache adapter
     * 2. init database adapter
     *  i. load model ?
     */
    public function do_filter(): void {
        // 1. cache adapter
        CacheRepository::add_server(ConfigRepository::get_redis_server());

        /**
         * @todo database adapter
         */
    }
}
