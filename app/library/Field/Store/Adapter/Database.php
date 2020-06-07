<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Field\Store\Adapter;

use Bops\Exception\Framework\Mvc\Model\ModelSaveException;
use Here\Library\Field\Store\AbstractStore;
use Here\Library\Field\Store\StoreInterface;
use Here\Model\Field;


/**
 * Class Database
 *
 * @package Here\Library\Field\Store\Adapter
 */
class Database extends AbstractStore {

    /**
     * Returns the specify key whether is in the store
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
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
            switch ($field->getFieldValueType()) {
                case Field::FIELD_VALUE_TYPE_INTEGER:
                    return (int)$field->getFieldValue();
                case Field::FIELD_VALUE_TYPE_FLOAT:
                    return (float)$field->getFieldValue();
                case Field::FIELD_VALUE_TYPE_BOOLEAN:
                    return $field->getFieldValue() === 'true';
                case Field::FIELD_VALUE_TPE_SERIALIZED:
                    return unserialize($field->getFieldValue());
                case Field::FIELD_VALUE_TYPE_STRING:
                default:
                    return strval($field->getFieldValue());
            }
        }
        return value_of($default);
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
        $field = Field::autoFactory($key);
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
        $field = Field::autoFactory($key);
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
        $field = Field::autoFactory($key);
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
        $field = Field::autoFactory($key);
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
        $field = Field::autoFactory($key);
        $field->setSerializedField($key, $value);
        $field->save();

        return $this;
    }

}
