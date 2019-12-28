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

use Here\Library\Exception\Mvc\ModelSaveException;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;
use Throwable;


/**
 * Class AbstractModel
 * @package Here\Library\Model
 */
abstract class AbstractModel extends Model {

    /**
     * Sets up the model
     */
    public function initialize() {}

    /**
     * Returns the save and refresh succeed both
     *
     * @param null $data
     * @param null $whiteList
     * @return bool
     * @throws ModelSaveException
     */
    public function save($data = null, $whiteList = null) {
        try {
            if (parent::save($data, $whiteList) && $this->refresh()) {
                return true;
            }
            throw new ModelSaveException(join('|', $this->getMessages()));
        } catch (Throwable $e) {
            throw new ModelSaveException($e->getMessage());
        }
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
     * Execute the dql statement and returns number of affected rows
     *
     * @param string $sql
     * @param mixed ...$args
     * @return int
     */
    protected function dml(string $sql, ...$args): int {
        $db = container('db');

        $db->execute($this->prepareSql($sql), $args);
        return $db->affectedRows();
    }

    /**
     * Returns string of the sql replaced
     *
     * @param string $sql
     * @return string
     */
    private function prepareSql(string $sql): string {
        return mb_ereg_replace('__table__', $this->getSource(), $sql);
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
