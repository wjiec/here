<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Library\Middleware\Adapter;

use Here\Library\Middleware\MiddlewareInterface;
use Phalcon\Cache\BackendInterface;


/**
 * Class Cache
 * @package Here\Library\Middleware\Adapter
 */
class Cache implements MiddlewareInterface {

    /**
     * @var BackendInterface
     */
    protected $cache;

    /**
     * Initials the cache from the container
     */
    public function __construct() {
        $this->cache = container('cache');
    }

    /**
     * Retrieval the value from cache and persistent
     * value to cache when cache not exists.
     *
     * @param string $name
     * @param $value
     * @param int $ttl
     * @return mixed|null
     */
    public function setDefault(string $name, $value = null, ?int $ttl = null) {
        if (!$this->cache->exists($name)) {
            $data = value_of($value);
            if ($data) {
                $this->cache->save($name, $value, $ttl);
            }
            return $data;
        }
        return $this->cache->get($name);
    }

}
