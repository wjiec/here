<?php
/**
 * ArticleAnalyses.php
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
 * Class ArticleAnalyses
 */
final class ArticleAnalyses extends Model {

    /**
     *
     * @var integer
     */
    public $analysis_id;

    /**
     *
     * @var integer
     */
    public $article_id;

    /**
     *
     * @var integer
     */
    public $view_count;

    /**
     *
     * @var integer
     */
    public $like_count;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('article_analyses');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'article_analyses';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleAnalyses[]|ArticleAnalyses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleAnalyses|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}