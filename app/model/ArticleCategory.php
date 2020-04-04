<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Mvc\Model;


/**
 * Class ArticleCategory
 *
 * @package Here\Model
 *
 * @property Article $article
 * @property Category $category
 */
class ArticleCategory extends Model {

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
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('article_category');

        $this->belongsTo('article_id', Article::class, 'article_id', [
            'alias' => 'article',
            'reusable' => true
        ]);

        $this->belongsTo('category_id', Category::class, 'category_id', [
            'alias' => 'category',
            'reusable' => true
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'article_category';
    }

    /**
     * Method to set the value of field article_id
     *
     * @param integer $article_id
     * @return $this
     */
    public function setArticleId(int $article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    /**
     * Method to set the value of field category_id
     *
     * @param integer $category_id
     * @return $this
     */
    public function setCategoryId(int $category_id) {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Returns the value of field relation_id
     *
     * @return integer
     */
    public function getRelationId(): int {
        return (int)$this->relation_id;
    }

    /**
     * Returns the value of field article_id
     *
     * @return integer
     */
    public function getArticleId(): int {
        return (int)$this->article_id;
    }

    /**
     * Returns the value of field category_id
     *
     * @return integer
     */
    public function getCategoryId(): int {
        return (int)$this->category_id;
    }

    /**
     * Factory new relation of article and category
     *
     * @param int $article_id
     * @param int $category_id
     * @return static
     */
    public static function factory(int $article_id, int $category_id): self {
        $relation = new static();
        $relation->setArticleId($article_id);
        $relation->setCategoryId($category_id);

        return $relation;
    }

}
