<?php
/**
 * CleanRequestUri.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Filter;
use Here\Config\Constant\SysConstant;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;


/**
 * Class CleanRequestUri
 * @package Here\Lib\Router\Filter
 */
final class CleanRequestUri extends FilterChainProxyBase {
    /**
     * @var string
     */
    private $_request_uri;

    /**
     * CleanRequestUri constructor.
     * @param string $request_uri
     */
    final public function __construct(string &$request_uri) {
        $this->_request_uri = &$request_uri;
    }

    /**
     * trim `Url Separator` for request uri
     */
    final public function do_filter(): void {
        $this->_request_uri = trim($this->_request_uri, SysConstant::URL_SEPARATOR);

        $this->next();
    }
}
