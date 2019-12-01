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
namespace Here\Library\Mvc\Model;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;


/**
 * Class AbstractModel
 * @package Here\Library\Model
 */
abstract class AbstractModel extends Model {

    /**
     * Returns the save and refresh succeed both
     *
     * @return bool
     */
    public function refreshAfterSave(): bool {
        return $this->save() && $this->refresh();
    }

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
        return parent::findFirst($parameters) ?: null;
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
