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
    protected $_adapter;

    /**
     * CacheDataBase constructor.
     * @param string $key
     */
    final public function __construct(string $key) {
        $this->_key = $key;
        $this->_value = $this->default_value();
        $this->_adapter = null;
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
        return $this->_value;
    }

    /**
     * @param int $expired
     * @return bool
     */
    final public function set_expired(int $expired): bool {
        return $this->_adapter->set_ttl($this->get_key(), $expired);
    }

    /**
     * @return int
     */
    final public function get_expired(): int {
        return $this->_adapter->get_ttl($this->get_key());
    }

    /**
     * @return bool
     */
    final public function remove_expired(): bool {
        return $this->_adapter->persist_item($this->get_key());
    }

    /**
     * @return int
     */
    final public function destroy(): int {
        return $this->_adapter->destroy_item($this->get_key());
    }

    /**
     * @param CacheAdapterInterface $adapter
     * @return bool
     */
    final public function persistent(CacheAdapterInterface $adapter): bool {
        return $adapter->string_item_cache($this->get_key(), $this->get_value());
    }

    /**
     * @return mixed
     */
    abstract public function default_value();
}
