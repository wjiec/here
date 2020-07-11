<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Mvc\Model;


/**
 * Class ArticleTag
 *
 * @package Here\Model
 *
 * @property Article $article
 * @property Tag $tag
 */
class ArticleTag extends Model {

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
    protected $tag_id;

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
     * Method to set the value of field tag_id
     *
     * @param integer $tag_id
     * @return $this
     */
    public function setTagId(int $tag_id) {
        $this->tag_id = $tag_id;

        return $this;
    }

    /**
     * Returns the value of field relation_id
     *
     * @return integer
     */
    public function getRelationId() {
        return (int)$this->relation_id;
    }

    /**
     * Returns the value of field article_id
     *
     * @return integer
     */
    public function getArticleId() {
        return (int)$this->article_id;
    }

    /**
     * Returns the value of field tag_id
     *
     * @return integer
     */
    public function getTagId() {
        return (int)$this->tag_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('article_tag');

        $this->belongsTo('article_id', Article::class, 'article_id', [
            'alias' => 'article',
            'reusable' => true
        ]);

        $this->belongsTo('tag_id', Tag::class, 'tag_id', [
            'alias' => 'article',
            'reusable' => true
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'article_tag';
    }

}
