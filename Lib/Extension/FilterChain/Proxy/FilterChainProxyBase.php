<?php
/**
 * FilterChainProxyBase.php
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
 * Class FilterChainProxyBase
 * @package Here\Lib\Extension\FilterChain\Proxy
 */
abstract class FilterChainProxyBase implements FilterChainProxyInterface {
    /**
     * @var FilterChainInterface
     */
    private $_filter_chain;

    /**
     * @param FilterChainInterface $filter_chain
     */
    final public function set_filter_chain(FilterChainInterface $filter_chain): void {
        $this->_filter_chain = $filter_chain;
    }

    /**
     * proxy to next filter in `FilterChain`
     */
    final public function next(): void {
        $this->_filter_chain->next();
    }

    /**
     * default filter do nothing
     */
    public function do_filter(): void {
        $this->next();
    }
}
