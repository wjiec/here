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


/**
 * Class Composition
 *
 * @package Here\Library\Field\Store\Adapter
 */
class Composition extends AbstractStore {

    /**
     * stores
     *
     * @var StoreInterface[]
     */
    protected $stores;

    /**
     * Mixed constructor.
     * @param StoreInterface[] $stores
     */
    public function __construct(StoreInterface ...$stores) {
        $this->stores = $stores;
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        foreach ($this->stores as $store) {
            if ($store->has($key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the value of specify key in the store. Returns
     * default when the key not exists in all stores
     *
     * @param string $key
     * @param null $default
     * @return string|integer|float|bool|null
     */
    public function get(string $key, $default = null) {
        $hitMissingStores = [];
        foreach ($this->stores as $store) {
            if ($store->has($key)) {
                $value = $store->get($key);
                foreach ($hitMissingStores as $hitMissingStore) {
                    $hitMissingStore->set($key, $value);
                }
                return $value;
            }

            $hitMissingStores[] = $store;
        }

        $value = value_of($default);
        foreach ($hitMissingStores as $hitMissingStore) {
            $hitMissingStore->set($key, $value);
        }
        return $value;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    public function setString(string $key, string $value): StoreInterface {
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
    public function setInteger(string $key, int $value): StoreInterface {
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
    public function setFloat(string $key, int $value): StoreInterface {
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
    public function setBoolean(string $key, bool $value): StoreInterface {
        foreach ($this->stores as $store) {
            $store->setBoolean($key, $value);
        }
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
        foreach ($this->stores as $store) {
            $store->setSerialized($key, $value);
        }
        return $this;
    }

}
