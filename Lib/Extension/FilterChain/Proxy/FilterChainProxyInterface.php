<?php
/**
 * FilterChainProxyInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\FilterChain\Proxy;
use Here\Lib\Extension\FilterChain\FilterChainInterface;


/**
 * Interface FilterChainProxyInterface
 * @package Here\Lib\Extension\FilterChain\Proxy
 */
interface FilterChainProxyInterface extends FilterChainInterface {
    /**
     * @param FilterChainInterface $filter_chain
     */
    public function set_filter_chain(FilterChainInterface $filter_chain): void;
}
