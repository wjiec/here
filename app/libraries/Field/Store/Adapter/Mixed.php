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


/**
 * Class Mixed
 * @package Here\Libraries\Field\Store\Adapter
 */
final class Mixed extends AbstractStore {

    /**
     * @var StoreInterface[]
     */
    private $stores;

    /**
     * Mixed constructor.
     * @param StoreInterface ...$stores
     */
    final public function __construct(StoreInterface ...$stores) {
        $this->stores = $stores;
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    final public function exists(string $key): bool {
        foreach ($this->stores as $store) {
            if ($store->exists($key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the value of specify key in the store. Returns
     * default when the key not exists
     *
     * @param string $key
     * @param null $default
     * @return string|integer|float|bool|null
     */
    final public function get(string $key, $default = null) {
        $missing_stores = array();
        foreach ($this->stores as $store) {
            $value = $store->get($key, $default);
            if ($value !== $default) {
                /* @var StoreInterface $missing_store */
                foreach ($missing_stores as $missing_store) {
                    $missing_store->set($key, $value);
                }
                return $value;
            }
            $missing_stores[] = $store;
        }
        return $default;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    final public function setString(string $key, string $value): StoreInterface {
        foreach ($this->stores as $store) {
            $store->setString($key, $value);
        }
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
        foreach ($this->stores as $store) {
            $store->setInteger($key, $value);
        }
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
        foreach ($this->stores as $store) {
            $store->setFloat($key, $value);
        }
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
        foreach ($this->stores as $store) {
            $store->setBoolean($key, $value);
        }
        return $this;
    }

}
