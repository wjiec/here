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
use Here\Models\Field;


/**
 * Class Database
 * @package Here\Libraries\Field\Store\Adapter
 */
final class Database extends AbstractStore {

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    final public function exists(string $key): bool {
        return Field::findByColumn($key) !== null;
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
        return ($field = Field::findByColumn($key)) ? $field->getRealFieldValue() : $default;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     */
    final public function setString(string $key, string $value): StoreInterface {
        $field = Field::findByColumn($key) ?? Field::factory($key);
        $field->setStringField($key, $value);
        $field->save();

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
        $field = Field::findByColumn($key) ?? Field::factory($key);
        $field->setIntegerField($key, $value);
        $field->save();

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
        $field = Field::findByColumn($key) ?? Field::factory($key);
        $field->setFloatField($key, $value);
        $field->save();

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
        $field = Field::findByColumn($key) ?? Field::factory($key);
        $field->setBooleanField($key, $value);
        $field->save();

        return $this;
    }

}
