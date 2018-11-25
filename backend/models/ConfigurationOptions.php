<?php
/**
 * ConfigurationOptions.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Models;


use \Phalcon\Mvc\Model;


/**
 * Class ConfigurationOptions
 * @package Here\Models
 */
final class ConfigurationOptions extends Model {

    /**
     *
     * @var integer
     */
    public $option_id;

    /**
     *
     * @var string
     */
    public $option_name;

    /**
     *
     * @var string
     */
    public $option_value;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('configuration_options');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'configuration_options';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConfigurationOptions[]|ConfigurationOptions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConfigurationOptions|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
