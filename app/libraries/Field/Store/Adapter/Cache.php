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
namespace Here\Libraries\Field\Store\Adapter;

use Here\Libraries\Field\Store\AbstractStore;
use Here\Libraries\Field\Store\StoreInterface;
use Phalcon\Cache\BackendInterface;


/**
 * Class Cache
 * @package Here\Libraries\Field\Store\Adapter
 */
final class Cache extends AbstractStore {

    /**
     * @var BackendInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * Cache constructor.
     *
     * @param int $lifetime
     * @param null|BackendInterface $backend
     */
    final public function __construct(int $lifetime = 3600, ?BackendInterface $backend = null) {
        $this->cache = $backend ?? container('cache');
        $this->lifetime = 3600;
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    final public function exists(string $key): bool {
        return $this->cache->exists($key);
    }

    /**
     * Get the value of specify key in the store. Returns
     * default when the key not exists
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    final public function get(string $key, $default = null) {
        return unserialize($this->cache->get($key)) ?: $default;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    final public function setString(string $key, string $value): StoreInterface {
        return $this->save($key, $value);
    }

    /**
     * Add a integer value to the store
     *
     * @param string $key
     * @param int $value
     * @return StoreInterface
     */
    final public function setInteger(string $key, int $value): StoreInterface {
        return $this->save($key, $value);
    }

    /**
     * Add a float value to the store
     *
     * @param string $key
     * @param int $value
     * @return StoreInterface
     */
    final public function setFloat(string $key, int $value): StoreInterface {
        return $this->save($key, $value);
    }

    /**
     * Add a boolean value to the store
     *
     * @param string $key
     * @param bool $value
     * @return StoreInterface
     */
    final public function setBoolean(string $key, bool $value): StoreInterface {
        return $this->save($key, $value);
    }

    /**
     * Save a key-value pair to cache backend
     *
     * @param string $key
     * @param $value
     * @return StoreInterface
     */
    final private function save(string $key, $value): StoreInterface {
        $this->cache->save($key, serialize($value), $this->lifetime);
        return $this;
    }

}
