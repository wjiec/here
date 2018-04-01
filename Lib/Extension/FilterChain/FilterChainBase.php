<?php
/**
 * FilterChainBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\FilterChain;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyInterface;


/**
 * Class FilterChainBase
 * @package Here\Lib\Extension\FilterChain
 */
abstract class FilterChainBase implements FilterChainInterface {
    /**
     * @var FilterChainInterface[]
     */
    private $_filters;

    /**
     * @var int
     */
    private $_current;

    /**
     * FilterChainBase constructor.
     */
    public function __construct() {
        $this->_filters = array();
        $this->_current = -1;
    }

    /**
     * @param FilterChainProxyInterface $filter
     * @return FilterChainBase
     */
    final public function register_filter(FilterChainProxyInterface $filter): self {
        $filter->set_filter_chain($this);
        $this->_filters[] = $filter;
        return $this;
    }

    /**
     * run next filter and save current stack
     */
    final public function next(): void {
        if ($this->has_next_filter()) {
            $this->_filters[++$this->_current]->do_filter();
        }
    }

    /**
     * start filter chain
     */
    final public function start_filter(): void {
        $this->_current = -1;
        $this->do_filter();
    }

    /**
     * simple filter do something
     */
    public function do_filter(): void {
        $this->next();
    }

    /**
     * @return bool
     */
    final private function has_next_filter(): bool {
        return !empty($this->_filters) && $this->_current !== count($this->_filters) - 1;
    }
}
