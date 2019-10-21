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
namespace Here\Library\Model;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;


/**
 * Class AbstractModel
 * @package Here\Library\Model
 */
abstract class AbstractModel extends Model {

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ResultsetInterface
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Model|$this|null
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * Boolean value true
     */
    public const BOOLEAN_TRUE = 1;

    /**
     * Boolean value false
     */
    public const BOOLEAN_FALSE = 0;

}
