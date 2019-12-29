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

use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Provider\Field\Store\AbstractStore;
use Here\Provider\Field\Store\StoreInterface;
use Here\Model\Field;


/**
 * Class Database
 * @package Here\Provider\Field\Store\Adapter
 */
class Database extends AbstractStore {

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool {
        return Field::findByKey($key) !== null;
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
        if ($field = Field::findByKey($key)) {
            return $field->getRealFieldValue();
        }
        return $default;
    }

    /**
     * Add a string value to the store
     *
     * @param string $key
     * @param string $value
     * @return StoreInterface
     * @throws ModelSaveException
     */
    public function setString(string $key, string $value): StoreInterface {
        $field = Field::findByKey($key) ?? Field::factory($key);
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
     * @throws ModelSaveException
     */
    public function setInteger(string $key, int $value): StoreInterface {
        $field = Field::findByKey($key) ?? Field::factory($key);
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
     * @throws ModelSaveException
     */
    public function setFloat(string $key, int $value): StoreInterface {
        $field = Field::findByKey($key) ?? Field::factory($key);
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
     * @throws ModelSaveException
     */
    public function setBoolean(string $key, bool $value): StoreInterface {
        $field = Field::findByKey($key) ?? Field::factory($key);
        $field->setBooleanField($key, $value);
        $field->save();

        return $this;
    }

    /**
     * Add a serialized value to the store
     *
     * @param string $key
     * @param $value
     * @return StoreInterface
     * @throws ModelSaveException
     */
    public function setSerialized(string $key, $value): StoreInterface {
        $field = Field::findByKey($key) ?? Field::factory($key);
        $field->setSerializedField($key, $value);
        $field->save();

        return $this;
    }

}
