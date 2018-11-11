<?php
/**
 * Articles.php
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
 * Class Articles
 * @package Here\Models
 */
final class Articles extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var string
     */
    public $article_title;

    /**
     *
     * @var string
     */
    public $article_description;

    /**
     *
     * @var integer
     */
    public $author_id;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     *
     * @var string
     */
    public $article_contents;

    /**
     *
     * @var integer
     */
    public $category_id;

    /**
     *
     * @var integer
     */
    public $private;

    /**
     *
     * @var string
     */
    public $article_status;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $close_comment;

    /**
     *
     * @var integer
     */
    public $license_id;

    /**
     *
     * @var integer
     */
    public $group_id;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSchema("here");
        $this->setSource("articles");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'articles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articles[]|Articles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articles|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
