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
namespace Here\Provider\Field\Store;


use Throwable;

/**
 * Class AbstractStore
 * @package Here\Provider\Field\Store
 */
abstract class AbstractStore implements StoreInterface {

    /**
     * @inheritdoc
     *
     * @param string $key
     * @param $value
     * @return StoreInterface
     */
    public function set(string $key, $value): StoreInterface {
        switch (true) {
            case is_string($value):
                return $this->setString($key, $value);
            case is_integer($value):
                return $this->setInteger($key, $value);
            case is_float($value):
                return $this->setFloat($key, $value);
            case is_bool($value):
                return $this->setBoolean($key, $value);
            default:
                return $this->setString($key, serialize($value));
        }
    }

    /**
     * @inheritDoc
     * @param string $key
     * @param null $default
     * @return mixed|void
     */
    public function get(string $key, $default = null) {
        $value = $this->doGet($key, $default);
        return is_string($value) ? self::decodeString($value) : $value;
    }

    /**
     * Gets the raw value from store
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    protected function doGet(string $key, $default = null) {
        return $default;
    }

    /**
     * Returns the real-value when serialized, raw string otherwise
     *
     * @param string $value
     * @return mixed|string
     */
    protected static function decodeString(string $value) {
        try {
            return unserialize($value);
        } catch (Throwable $e) {
            return $value;
        }
    }

}
