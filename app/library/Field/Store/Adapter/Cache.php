<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Field\Store\Adapter;

use Here\Library\Field\Store\AbstractStore;
use Here\Library\Field\Store\StoreInterface;
use Phalcon\Cache\BackendInterface;


/**
 * Class Cache
 *
 * @package Here\Library\Field\Store\Adapter
 */
class Cache extends AbstractStore {

    /**
     * cache backend
     *
     * @var BackendInterface
     */
    protected $cache;

    /**
     * field lifetime
     *
     * @var int
     */
    protected $lifetime;

    /**
     * prefix for field key
     *
     * @var string
     */
    protected $prefix = ':field:';

    /**
     * Cache constructor.
     *
     * @param BackendInterface $backend
     * @param int $lifetime
     */
    public function __construct(BackendInterface $backend, int $lifetime = 300) {
        $this->cache = $backend;
        $this->lifetime = $lifetime;
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        return $this->cache->exists($this->prefix . $key);
    }

    /**
     * Get the value of specify key in the store. Returns
     * default when the key not exists
     *
     * @param string $key
     * @param null $default
     * @return mixed|void
     */
    public function get(string $key, $default = null) {
        // deserialize by phalcon cache frontend
        return $this->cache->get($this->prefix . $key) ?: value_of($default);
    }

    /**
     * remove key from store
     *
     * @param string $key
     * @return StoreInterface
     */
    public function del(string $key): StoreInterface {
        $this->cache->delete($key);
        return $this;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    public function setString(string $key, string $value): StoreInterface {
        // serialize by phalcon cache frontend
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);
        return $this;
    }

    /**
     * Add a integer value to the store
     *
     * @param string $key
     * @param int $value
     * @return StoreInterface
     */
    public function setInteger(string $key, int $value): StoreInterface {
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);
        return $this;
    }

    /**
     * Add a float value to the store
     *
     * @param string $key
     * @param int $value
     * @return StoreInterface
     */
    public function setFloat(string $key, int $value): StoreInterface {
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);
        return $this;
    }

    /**
     * Add a boolean value to the store
     *
     * @param string $key
     * @param bool $value
     * @return StoreInterface
     */
    public function setBoolean(string $key, bool $value): StoreInterface {
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);
        return $this;
    }

    /**
     * Add a serialized value to the store
     *
     * @param string $key
     * @param $value
     * @return StoreInterface
     */
    public function setSerialized(string $key, $value): StoreInterface {
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);

        return $this;
    }

}
