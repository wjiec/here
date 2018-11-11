<?php
/**
 * ArticleCategories.php
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
 * Class ArticleCategories
 * @package Here\Models
 */
final class ArticleCategories extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var string
     */
    public $category_name;

    /**
     *
     * @var string
     */
    public $category_description;

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
        $this->setSource("article_categories");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'article_categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleCategories[]|ArticleCategories|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleCategories|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
