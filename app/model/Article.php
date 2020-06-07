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
use Phalcon\Mvc\Model\Resultset\Simple;


/**
 * Class Article
 *
 * @package Here\Model
 *
 * @property Author $author
 *
 * @property Simple $tagRelation
 * @method Simple getTagRelation($parameters = null)
 *
 * @property Simple $comments
 * @method Simple getComments($parameters = null)
 */
class Article extends Model {

    /**
     *
     * @var integer
     */
    protected $article_id;

    /**
     *
     * @var integer
     */
    protected $author_id;

    /**
     *
     * @var string
     */
    protected $article_title;

    /**
     *
     * @var string
     */
    protected $article_outline;

    /**
     *
     * @var string
     */
    protected $article_content;

    /**
     *
     * @var bool
     */
    protected $article_publish;

    /**
     *
     * @var bool
     */
    protected $article_allow_comment;

    /**
     *
     * @var integer
     */
    protected $article_view;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     *
     * @var string
     */
    protected $update_time;

    /**
     *
     * @var string
     */
    protected $publish_time;

    /**
     * Method to set the value of field author_id
     *
     * @param integer $authorId
     * @return $this
     */
    public function setAuthorId(int $authorId) {
        $this->author_id = $authorId;

        return $this;
    }

    /**
     * Method to set the value of field article_title
     *
     * @param string $articleTitle
     * @return $this
     */
    public function setArticleTitle(string $articleTitle) {
        $this->article_title = $articleTitle;

        return $this;
    }

    /**
     * Method to set the value of field article_outline
     *
     * @param string $articleOutline
     * @return $this
     */
    public function setArticleOutline(string $articleOutline) {
        $this->article_outline = $articleOutline;

        return $this;
    }

    /**
     * Method to set the value of field article_content
     *
     * @param string $articleContent
     * @return $this
     */
    public function setArticleContent(string $articleContent) {
        $this->article_content = $articleContent;

        return $this;
    }

    /**
     * Method to set the value of field article_publish
     *
     * @param bool $articlePublish
     * @return $this
     */
    public function setArticlePublish(bool $articlePublish) {
        $this->article_publish = $articlePublish;

        return $this;
    }

    /**
     * Method to set the value of field article_allow_comment
     *
     * @param bool $articleAllowComment
     * @return $this
     */
    public function setArticleAllowComment(bool $articleAllowComment) {
        $this->article_allow_comment = $articleAllowComment;

        return $this;
    }

    /**
     * Method to set the value of field article_view
     *
     * @param integer $articleView
     * @return $this
     */
    public function setArticleView(int $articleView) {
        $this->article_view = $articleView;

        return $this;
    }

    /**
     * Method to set the value of field update_time
     *
     * @param string $updateTime
     * @return $this
     */
    public function setUpdateTime(string $updateTime) {
        $this->update_time = $updateTime;

        return $this;
    }

    /**
     * Method to set the value of field publish_time
     *
     * @param string $publishTime
     * @return $this
     */
    public function setPublishTime(string $publishTime) {
        $this->publish_time = $publishTime;

        return $this;
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
     * Returns the value of field author_id
     *
     * @return integer
     */
    public function getAuthorId() {
        return (int)$this->author_id;
    }

    /**
     * Returns the value of field article_title
     *
     * @return string
     */
    public function getArticleTitle() {
        return $this->article_title;
    }

    /**
     * Returns the value of field article_outline
     *
     * @return string
     */
    public function getArticleOutline() {
        return $this->article_outline;
    }

    /**
     * Returns the value of field article_content
     *
     * @return string
     */
    public function getArticleContent() {
        return $this->article_content;
    }

    /**
     * Returns the value of field article_publish
     *
     * @return string
     */
    public function getArticlePublish() {
        return $this->article_publish;
    }

    /**
     * Returns the value of field article_allow_comment
     *
     * @return string
     */
    public function getArticleAllowComment() {
        return $this->article_allow_comment;
    }

    /**
     * Returns the value of field article_view
     *
     * @return integer
     */
    public function getArticleView() {
        return (int)$this->article_view;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    public function getCreateTime() {
        return $this->create_time;
    }

    /**
     * Returns the value of field update_time
     *
     * @return string
     */
    public function getUpdateTime() {
        return $this->update_time;
    }

    /**
     * Returns the value of field publish_time
     *
     * @return string
     */
    public function getPublishTime() {
        return $this->publish_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('article');

        $this->belongsTo('author_id', Article::class, 'author_id', [
            'alias' => 'author',
            'reusable' => true,
        ]);

        $this->hasMany('article_id', ArticleTag::class, 'article_id', [
            'alias' => 'tagRelation',
        ]);

        $this->hasMany('article_id', Comment::class, 'article_id', [
            'alias' => 'comments',
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'article';
    }

}
