<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Field\Store\Adapter;

use Here\Provider\Field\Store\AbstractStore;
use Here\Provider\Field\Store\StoreInterface;
use Phalcon\Cache\BackendInterface;


/**
 * Class Cache
 * @package Here\Provider\Field\Store\Adapter
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
     * @var string
     */
    private $prefix = ':field:';

    /**
     * Cache constructor.
     *
     * @param int $lifetime
     */
    final public function __construct(int $lifetime = 3600) {
        $this->cache = container('cache');
        $this->lifetime = $lifetime;
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    final public function exists(string $key): bool {
        return $this->cache->exists($this->prefix . $key);
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
        // deserialize by phalcon cache frontend
        return $this->cache->get($this->prefix . $key) ?: $default;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    final public function setString(string $key, string $value): StoreInterface {
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
    final public function setInteger(string $key, int $value): StoreInterface {
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
    final public function setFloat(string $key, int $value): StoreInterface {
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
    final public function setBoolean(string $key, bool $value): StoreInterface {
        $this->cache->save($this->prefix . $key, $value, $this->lifetime);
        return $this;
    }

}
