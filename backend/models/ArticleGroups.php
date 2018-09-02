<?php
/**
 * ArticleGroups.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Models;


use \Phalcon\Mvc\Model;


/**
 * Class ArticleGroups
 * @package Here\Models
 */
final class ArticleGroups extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var string
     */
    public $group_name;

    /**
     *
     * @var string
     */
    public $group_description;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSchema("here");
        $this->setSource("article_groups");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'article_groups';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleGroups[]|ArticleGroups|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleGroups|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
