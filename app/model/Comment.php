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
 * Class Comment
 * @package Here\Model
 */
final class Comment extends AbstractModel {

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
    protected $comment_author;

    /**
     *
     * @var string
     */
    protected $comment_author_email;

    /**
     *
     * @var string
     */
    protected $comment_author_ip;

    /**
     *
     * @var string
     */
    protected $comment_author_agent;

    /**
     *
     * @var string
     */
    protected $comment_body;

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
     * Method to set the value of field article_id
     *
     * @param integer $article_id
     * @return $this
     */
    final public function setArticleId(int $article_id) {
        $this->article_id = (int)$article_id;
        return $this;
    }

    /**
     * Method to set the value of field comment_author
     *
     * @param string $comment_author
     * @return $this
     */
    final public function setCommentAuthor(string $comment_author) {
        $this->comment_author = $comment_author;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_email
     *
     * @param string $comment_author_email
     * @return $this
     */
    final public function setCommentAuthorEmail(string $comment_author_email) {
        $this->comment_author_email = $comment_author_email;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_ip
     *
     * @param string $comment_author_ip
     * @return $this
     */
    final public function setCommentAuthorIp(string $comment_author_ip) {
        $this->comment_author_ip = $comment_author_ip;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_agent
     *
     * @param string $comment_author_agent
     * @return $this
     */
    final public function setCommentAuthorAgent(string $comment_author_agent) {
        $this->comment_author_agent = $comment_author_agent;
        return $this;
    }

    /**
     * Method to set the value of field comment_body
     *
     * @param string $comment_body
     * @return $this
     */
    final public function setCommentBody(string $comment_body) {
        $this->comment_body = $comment_body;
        return $this;
    }

    /**
     * Method to set the field comment_status as pending status
     *
     * @return $this
     */
    final public function markCommentPending() {
        $this->comment_status = self::COMMENT_STATUS_PENDING;
        return $this;
    }

    /**
     * Method to set the field comment_status as auto_spammed status
     *
     * @return $this
     */
    final public function markCommentAutoSpammed() {
        $this->comment_status = self::markCommentAutoSpammed();
        return $this;
    }

    /**
     * Method to set the field comment_status as spammed status
     *
     * @return $this
     */
    final public function markCommentSpammed() {
        $this->comment_status = self::COMMENT_STATUS_SPAMMED;
        return $this;
    }

    /**
     * Method to set the field comment_status as pending status
     *
     * @return $this
     */
    final public function markCommentPassed() {
        $this->comment_status = self::COMMENT_STATUS_COMMENTED;
        return $this;
    }

    /**
     * Method to set the value of field comment_parent
     *
     * @param integer $comment_parent
     * @return $this
     */
    final public function setCommentParent(int $comment_parent) {
        $this->comment_parent = $comment_parent;
        return $this;
    }

    /**
     * Returns the value of field comment_id
     *
     * @return integer
     */
    final public function getCommentId(): int {
        return (int)$this->comment_id;
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
     * Returns the value of field comment_author
     *
     * @return string
     */
    final public function getCommentAuthor(): ?string {
        return $this->comment_author;
    }

    /**
     * Returns the value of field comment_author_email
     *
     * @return string
     */
    final public function getCommentAuthorEmail(): ?string {
        return $this->comment_author_email;
    }

    /**
     * Returns the value of field comment_author_ip
     *
     * @return string
     */
    final public function getCommentAuthorIp(): ?string {
        return $this->comment_author_ip;
    }

    /**
     * Returns the value of field comment_author_agent
     *
     * @return string
     */
    final public function getCommentAuthorAgent(): ?string {
        return $this->comment_author_agent;
    }

    /**
     * Returns the value of field comment_body
     *
     * @return string
     */
    final public function getCommentBody(): ?string {
        return $this->comment_body;
    }

    /**
     * Returns the status of comment is pending
     *
     * @return bool
     */
    final public function isCommentPending(): bool {
        return $this->comment_status === self::COMMENT_STATUS_PENDING;
    }

    /**
     * Returns the status of comment is auto_spammed
     *
     * @return bool
     */
    final public function isCommentAutoSpammed(): bool {
        return $this->comment_status === self::COMMENT_STATUS_AUTO_SPAMMED;
    }

    /**
     * Returns the status of comment is spammed
     *
     * @return bool
     */
    final public function isCommentSpammed(): bool {
        return $this->comment_status === self::COMMENT_STATUS_SPAMMED;
    }

    /**
     * Returns the status of comment is pending
     *
     * @return bool
     */
    final public function isCommentPassed(): bool {
        return $this->comment_status === self::COMMENT_STATUS_COMMENTED;
    }

    /**
     * Returns the value of field comment_parent
     *
     * @return integer
     */
    final public function getCommentParent(): int {
        return (int)$this->comment_parent;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    final public function getCreateTime(): ?string {
        return $this->create_time;
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('comment');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'comment';
    }

    /**
     * Waiting to author check
     */
    public const COMMENT_STATUS_PENDING = 'pending';

    /**
     * Spammed by AntiSpam
     */
    public const COMMENT_STATUS_AUTO_SPAMMED = 'auto_spammed';

    /**
     * Spammed by author
     */
    public const COMMENT_STATUS_SPAMMED = 'spammed';

    /**
     * Comment has passed
     */
    public const COMMENT_STATUS_COMMENTED = 'commented';

}
