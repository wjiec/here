<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Mvc\Model;


/**
 * Class Field
 *
 * @package Here\Model
 */
class Field extends Model {

    /**
     *
     * @var integer
     */
    protected $field_id;

    /**
     *
     * @var string
     */
    protected $field_key;

    /**
     *
     * @var string
     */
    protected $field_value;

    /**
     *
     * @var string
     */
    protected $field_value_type;

    /**
     * Method to set the value of field field_key
     *
     * @param string $field_key
     * @return $this
     */
    public function setFieldKey(string $field_key) {
        $this->field_key = $field_key;

        return $this;
    }

    /**
     * Method to set the value of field field_value
     *
     * @param string $field_value
     * @return $this
     */
    public function setFieldValue(string $field_value) {
        $this->field_value = $field_value;

        return $this;
    }

    /**
     * Method to set the value of field field_value_type
     *
     * @param string $field_value_type
     * @return $this
     */
    public function setFieldValueType(string $field_value_type) {
        $this->field_value_type = $field_value_type;

        return $this;
    }

    /**
     * Returns the value of field field_id
     *
     * @return integer
     */
    public function getFieldId() {
        return (int)$this->field_id;
    }

    /**
     * Returns the value of field field_key
     *
     * @return string
     */
    public function getFieldKey() {
        return $this->field_key;
    }

    /**
     * Returns the value of field field_value
     *
     * @return string
     */
    public function getFieldValue() {
        return $this->field_value;
    }

    /**
     * Returns the value of field field_value_type
     *
     * @return string
     */
    public function getFieldValueType() {
        return $this->field_value_type;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('field');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'field';
    }

}
