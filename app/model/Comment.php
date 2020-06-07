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
 * Class Comment
 *
 * @package Here\Model
 *
 * @property Article $article
 * @property Comment $parent
 */
class Comment extends Model {

    /**
     *
     * @var integer
     */
    protected $comment_id;

    /**
     *
     * @var integer
     */
    protected $article_id;

    /**
     *
     * @var string
     */
    protected $commentator_nickname;

    /**
     *
     * @var string
     */
    protected $commentator_email;

    /**
     *
     * @var string
     */
    protected $commentator_ip;

    /**
     *
     * @var string
     */
    protected $commentator_browser;

    /**
     *
     * @var string
     */
    protected $comment_content;

    /**
     *
     * @var string
     */
    protected $comment_status;

    /**
     *
     * @var integer
     */
    protected $comment_parent;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     * Method to set the value of field comment_id
     *
     * @param integer $comment_id
     * @return $this
     */
    public function setCommentId(int $comment_id) {
        $this->comment_id = $comment_id;

        return $this;
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
     * Method to set the value of field commentator_nickname
     *
     * @param string $commentator_nickname
     * @return $this
     */
    public function setCommentatorNickname(string $commentator_nickname) {
        $this->commentator_nickname = $commentator_nickname;

        return $this;
    }

    /**
     * Method to set the value of field commentator_email
     *
     * @param string $commentator_email
     * @return $this
     */
    public function setCommentatorEmail(string $commentator_email) {
        $this->commentator_email = $commentator_email;

        return $this;
    }

    /**
     * Method to set the value of field commentator_ip
     *
     * @param string $commentator_ip
     * @return $this
     */
    public function setCommentatorIp(string $commentator_ip) {
        $this->commentator_ip = $commentator_ip;

        return $this;
    }

    /**
     * Method to set the value of field commentator_browser
     *
     * @param string $commentator_browser
     * @return $this
     */
    public function setCommentatorBrowser(string $commentator_browser) {
        $this->commentator_browser = $commentator_browser;

        return $this;
    }

    /**
     * Method to set the value of field comment_content
     *
     * @param string $comment_content
     * @return $this
     */
    public function setCommentContent(string $comment_content) {
        $this->comment_content = $comment_content;

        return $this;
    }

    /**
     * Method to set the value of field comment_status
     *
     * @param string $comment_status
     * @return $this
     */
    public function setCommentStatus(string $comment_status) {
        $this->comment_status = $comment_status;

        return $this;
    }

    /**
     * Method to set the value of field comment_parent
     *
     * @param integer $comment_parent
     * @return $this
     */
    public function setCommentParent(int $comment_parent) {
        $this->comment_parent = $comment_parent;

        return $this;
    }

    /**
     * Returns the value of field comment_id
     *
     * @return integer
     */
    public function getCommentId() {
        return (int)$this->comment_id;
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
     * Returns the value of field commentator_nickname
     *
     * @return string
     */
    public function getCommentatorNickname() {
        return $this->commentator_nickname;
    }

    /**
     * Returns the value of field commentator_email
     *
     * @return string
     */
    public function getCommentatorEmail() {
        return $this->commentator_email;
    }

    /**
     * Returns the value of field commentator_ip
     *
     * @return string
     */
    public function getCommentatorIp() {
        return $this->commentator_ip;
    }

    /**
     * Returns the value of field commentator_browser
     *
     * @return string
     */
    public function getCommentatorBrowser() {
        return $this->commentator_browser;
    }

    /**
     * Returns the value of field comment_content
     *
     * @return string
     */
    public function getCommentContent() {
        return $this->comment_content;
    }

    /**
     * Returns the value of field comment_status
     *
     * @return string
     */
    public function getCommentStatus() {
        return $this->comment_status;
    }

    /**
     * Returns the value of field comment_parent
     *
     * @return integer
     */
    public function getCommentParent() {
        return $this->comment_parent;
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
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('comment');

        $this->belongsTo('article_id', Article::class, 'article_id', [
            'alias' => 'article',
            'reusable' => true,
        ]);

        $this->belongsTo('comment_parent', self::class, 'comment_id', [
            'alias' => 'parent',
            'reusable' => true,
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'comment';
    }

}
