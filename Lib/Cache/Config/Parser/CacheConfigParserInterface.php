<?php
/**
 * CacheConfigParserInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config\Parser;
use Here\Lib\Cache\Config\CacheServerConfigInterface;


/**
 * Interface ConfigParserInterface
 * @package Lib\Cache\Config\Parser
 */
interface CacheConfigParserInterface {
    /**
     * @param CacheConfigParserInterface $parser
     */
    public function add_parser(CacheConfigParserInterface $parser): void;

    /**
     * @param CacheServerConfigInterface $config
     * @return CacheServerConfigInterface|null
     */
    public function parse(CacheServerConfigInterface $config): ?CacheServerConfigInterface;
}
