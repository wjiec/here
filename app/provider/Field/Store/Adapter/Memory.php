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


/**
 * Class Memory
 * @package Here\Provider\Field\Store\Adapter
 */
class Memory extends AbstractStore {

    /**
     * @var array
     */
    private $store;

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
    public function exists(string $key): bool {
        return isset($this->store[$key]);
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
     * @inheritDoc
     * @param string $key
     * @param null $default
     * @return mixed|void
     */
    protected function doGet(string $key, $default = null) {
        return $this->store[$key] ?? $default;
    }

}
