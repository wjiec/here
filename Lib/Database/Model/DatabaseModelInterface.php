<?php
/**
 * DatabaseModelInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model;
use Here\Lib\Database\Criteria\DatabaseCriteriaInterface;
use Here\Lib\Database\Model\Collection\DatabaseModelCollectionInterface;


/**
 * Interface DatabaseModelInterface
 *
 * @package Here\Lib\Database\Model
 */
interface DatabaseModelInterface {
    /**
     * DatabaseModelInterface constructor.
     */
    public function __construct();

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelInterface
     */
    public static function one(DatabaseCriteriaInterface $criteria): DatabaseModelInterface;

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    public static function all(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface;

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    public static function find(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface;

    /**
     * @return bool
     */
    public function persistent(): bool;
}
