<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Field\Store\Adapter;

use Here\Provider\Field\Store\AbstractStore;
use Here\Provider\Field\Store\StoreInterface;


/**
 * Class Mixed
 * @package Here\Provider\Field\Store\Adapter
 */
final class Mixed extends AbstractStore {

    /**
     * @var StoreInterface[]
     */
    private $stores;

    /**
     * Mixed constructor.
     * @param StoreInterface[] $stores
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
     * default when the key not exists in all stores
     *
     * @param string $key
     * @param null $default
     * @return string|integer|float|bool|null
     */
    final public function get(string $key, $default = null) {
        $values = array_reduce($this->stores, function(array $carry, StoreInterface $store) use ($key) {
            if (!isset($carry['hit'])) {
                if ($store->exists($key)) {
                    $carry['hit'] = $store->get($key);
                } else {
                    $carry['missing'][] = $store;
                }
            }
            return $carry;
        }, ['missing' => []]);
        $values['hit'] = $values['hit'] ?? value_of($default);

        /* @var StoreInterface $store */
        foreach ($values['missing'] as $store) {
            $store->set($key, $values['hit']);
        }
        return $values['hit'];
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
