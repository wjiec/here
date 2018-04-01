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
     */
    final public function set_expired(int $expired): void {
        // TODO: Implement set_expired() method.
    }

    /**
     * @return int
     */
    final public function get_expired(): int {
        // TODO: Implement get_expired() method.
    }

    /**
     * @inheritdoc
     */
    final public function remove_expired(): void {
        // TODO: Implement remove_expired() method.
    }

    /**
     * @return int
     */
    final public function destroy(): int {
        // TODO: Implement destroy() method.
    }

    /**
     * @param CacheAdapterInterface $adapter
     * @return bool
     */
    final public function persistent(CacheAdapterInterface $adapter): bool {
        // TODO: Implement persistent() method.
    }

    /**
     * @return mixed
     */
    abstract protected function default_value();
}
