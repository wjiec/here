<?php
/**
 * OverFrequencyRejectFilter.php.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter;
use Here\Config\Constant\CachePrefixConstant;
use Here\Lib\Cache\Data\DataType\String\StringValue;
use Here\Lib\Config\ConfigRepository;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Router\Dispatcher;
use Here\Lib\Router\DispatchError;
use Here\Lib\Stream\IStream\Client\Request;
use Here\Lib\Utils\Toolkit\StringToolkit;


/**
 * Class overFrequencyRejectFilter
 *
 * @package Here\App\Blogger\Filter
 */
final class OverFrequencyRejectFilter extends FilterChainProxyBase {
    /**
     * reject over frequency user by forbidden ip address
     */
    final public function do_filter(): void {
        /* @var StringValue $count */
        $request_count = new StringValue(self::make_cache_key(Request::client_ip()));

        /* check request count */
        $current_count = $request_count->increment();
        if ($current_count === 1) {
            // new request user
            $request_count->set_expire(ConfigRepository::get_item('request.policy.time_limit'));
        } else if ($current_count > ConfigRepository::get_item('request.policy.count_limit')) {
            $request_count->assign('forbidden');
            $request_count->set_expire(ConfigRepository::get_item('request.policy.forbidden_time'));
        } else if ($current_count === 0) {
            // forbidden now, reset forbidden time
            $request_count->set_expire(ConfigRepository::get_item('request.policy.forbidden_time'));
            Dispatcher::trigger_error_directly(new DispatchError(403, 'request too frequent'));
        }

        $this->next();
    }

    /**
     * @param string $request_ip
     * @return string
     */
    final public function make_cache_key(string $request_ip): string {
        return StringToolkit::format('%s%s', CachePrefixConstant::CACHE_IP_POLICY_PREFIX, $request_ip);
    }
}
