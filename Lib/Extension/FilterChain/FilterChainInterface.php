<?php
/**
 * FilterChainInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\FilterChain;


/**
 * Interface FilterChainInterface
 * @package Here\Lib\Extension\FilterChainInterface
 */
interface FilterChainInterface {
    /**
     * filter logic in here
     */
    public function do_filter(): void;

    /**
     * run next filter
     */
    public function next(): void;
}
