<?php
/**
 * MethodAllowedFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Filter;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Router\AllowedMethods;
use Here\Lib\Router\DispatchError;


/**
 * Class MethodAllowedFilter
 * @package Here\Lib\Router\Filter
 */
final class MethodAllowedFilter extends FilterChainProxyBase {
    /**
     * @var string
     */
    private $_request_method;

    /**
     * MethodAllowedFilter constructor.
     * @param string $request_method
     */
    final public function __construct(string $request_method) {
        $this->_request_method = $request_method;
    }

    /**
     * check current request method can be pass
     *
     * @throws DispatchError
     */
    final public function do_filter(): void {
        if (!AllowedMethods::contains($this->_request_method)) {
            throw new DispatchError(405, "`{$this->_request_method}` is not allowed");
        }

        $this->next();
    }
}
