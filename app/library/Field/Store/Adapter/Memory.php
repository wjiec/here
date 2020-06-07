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
 * Class Memory
 *
 * @package Here\Library\Field\Store\Adapter
 */
class Memory extends AbstractStore {

    /**
     * store area
     *
     * @var array
     */
    protected $store;

    /**
     * Memory constructor.
     */
    public function __construct() {
        $this->store = [];
    }

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        return isset($this->store[$key]);
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
        return $this->store[$key] ?? value_of($default);
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    public function setString(string $key, string $value): StoreInterface {
        $this->store[$key] = $value;
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
        $this->store[$key] = $value;
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
        $this->store[$key] = $value;
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
        $this->store[$key] = $value;
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
        $this->store[$key] = $value;
        return $this;
    }

}
