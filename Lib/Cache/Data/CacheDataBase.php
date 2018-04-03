<?php
/**
 * CacheDataBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data;
use Here\Lib\Cache\Adapter\CacheAdapterInterface;


/**
 * Class CacheDataBase
 * @package Here\Lib\Cache\Data
 */
abstract class CacheDataBase implements CacheDataInterface {
    /**
     * @var string
     */
    protected $_key;

    /**
     * @var mixed
     */
    protected $_value;

    /**
     * @var CacheAdapterInterface
     */
    private $_adapter;

    /**
     * CacheDataBase constructor.
     * @param string $key
     * @param CacheAdapterInterface|null $adapter
     */
    final public function __construct(string $key, ?CacheAdapterInterface $adapter = null) {
        $this->_key = $key;
        /**
         * @todo constructor require adapter?
         */
        $this->_adapter = $adapter;
    }

    /**
     * @return string
     */
    final public function get_key(): string {
        return $this->_key;
    }

    /**
     * @return mixed
     */
    final public function get_value() {
        if ($this->_value) {
            return $this->_value;
        }

        $this->_value = $this->refresh_value();
        return $this->_value;
    }

    /**
     * @param int $expired
     * @return bool
     */
    final public function set_expire(int $expired): bool {
        return $this->_adapter->set_expire($this->get_key(), $expired);
    }

    /**
     * @return int
     */
    final public function get_expire(): int {
        return $this->_adapter->get_expire($this->get_key());
    }

    /**
     * @return bool
     */
    final public function remove_expire(): bool {
        return $this->_adapter->remove_expire($this->get_key());
    }

    /**
     * @return int
     */
    final public function destroy(): int {
        return $this->_adapter->delete_item($this->get_key());
    }

    /**
     * @param CacheAdapterInterface $adapter
     * @return bool
     */
    final public function persistent(CacheAdapterInterface $adapter): bool {
        return $adapter->string_create($this->get_key(), $this->get_value());
    }

    /**
     * @return CacheAdapterInterface
     */
    final protected function get_adapter(): CacheAdapterInterface {
        return $this->_adapter;
    }

    /**
     * @return mixed
     */
    abstract protected function refresh_value();
}
