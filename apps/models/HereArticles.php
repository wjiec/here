<?php
/**
 * here_articles model
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Models;


use Phalcon\Mvc\Model;


/**
 * Class HereArticles
 * @package Here\Backend\Models
 */
final class HereArticles extends Model {

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
    public $contents;

    /**
     *
     * @var integer
     */
    public $category_id;

    /**
     *
     * @var integer
     */
    public $accessible;

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
        $this->setSource("here_articles");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'here_articles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticles[]|HereArticles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticles|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
