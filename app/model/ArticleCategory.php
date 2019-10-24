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
namespace Here\Model;

use Here\Library\Mvc\Model\AbstractModel;


/**
 * Class ArticleCategory
 * @package Here\Model
 */
final class ArticleCategory extends AbstractModel {

    /**
     *
     * @var integer
     */
    protected $relation_id;

    /**
     *
     * @var integer
     */
    protected $article_id;

    /**
     *
     * @var integer
     */
    protected $category_id;

    /**
     * Method to set the value of field article_id
     *
     * @param integer $article_id
     * @return $this
     */
    final public function setArticleId(int $article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    /**
     * Method to set the value of field category_id
     *
     * @param integer $category_id
     * @return $this
     */
    final public function setCategoryId(int $category_id) {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Returns the value of field relation_id
     *
     * @return integer
     */
    final public function getRelationId(): int {
        return (int)$this->relation_id;
    }

    /**
     * Returns the value of field article_id
     *
     * @return integer
     */
    final public function getArticleId(): int {
        return (int)$this->article_id;
    }

    /**
     * Returns the value of field category_id
     *
     * @return integer
     */
    final public function getCategoryId(): int {
        return (int)$this->category_id;
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('article_category');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'article_category';
    }

}
