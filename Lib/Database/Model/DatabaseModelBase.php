<?php
/**
 * DatabaseModelBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model;
use Here\Lib\Database\Adapter\DatabaseAdapterInterface;
use Here\Lib\Database\Criteria\DatabaseCriteriaInterface;
use Here\Lib\Database\DatabaseHelper;
use Here\Lib\Database\Model\Collection\DatabaseModelCollectionInterface;


/**
 * Class DatabaseModelBase
 * @package Here\Lib\Database\Model
 */
abstract class DatabaseModelBase implements DatabaseModelInterface {
    /**
     * DatabaseModelBase constructor.
     */
    final public function __construct() {
    }

    /**
     * @return DatabaseAdapterInterface
     */
    final protected static function connection(): DatabaseAdapterInterface {
        return DatabaseHelper::get_adapter();
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelInterface
     */
    final public static function one(DatabaseCriteriaInterface $criteria): DatabaseModelInterface {
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    final public static function all(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface {
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    final public static function find(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface {
    }
}
