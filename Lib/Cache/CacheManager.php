<?php
/**
 * CacheManager.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache;
use Here\Lib\Cache\Adapter\CacheAdapterInterface;


/**
 * Class CacheManager
 * @package Here\Lib\Cache
 */
final class CacheManager {
    /**
     * @var CacheAdapterInterface
     */
    private $_adapter;

    /**
     * CacheManager constructor.
     * @param CacheAdapterInterface $adapter
     */
    final public function __construct(CacheAdapterInterface $adapter) {
        $this->_adapter = $adapter;
    }
}
