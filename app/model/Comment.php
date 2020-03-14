<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Here\Library\Mvc\Model\AbstractModel;


/**
 * Class Comment
 * @package Here\Model
 *
 * @property Article $article
 * @property Comment $parent
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
     * Initialize method for model.
     */
    final public function initialize() {
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
    final public function getSource() {
        return 'comment';
    }

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
     * @param string $commentator_nickname
     * @return $this
     */
    final public function setCommentatorNickname(string $commentator_nickname) {
        $this->commentator_nickname = $commentator_nickname;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_email
     *
     * @param string $commentator_email
     * @return $this
     */
    final public function setCommentatorEmail(string $commentator_email) {
        $this->commentator_email = $commentator_email;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_ip
     *
     * @param string $commentator_ip
     * @return $this
     */
    final public function setCommentatorIp(string $commentator_ip) {
        $this->commentator_ip = $commentator_ip;
        return $this;
    }

    /**
     * Method to set the value of field comment_author_agent
     *
     * @param string $commentator_browser
     * @return $this
     */
    final public function setCommentatorBrowser(string $commentator_browser) {
        $this->commentator_browser = $commentator_browser;
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
    final public function getCommentatorNickname(): ?string {
        return $this->commentator_nickname;
    }

    /**
     * Returns the value of field comment_author_email
     *
     * @return string
     */
    final public function getCommentatorEmail(): ?string {
        return $this->commentator_email;
    }

    /**
     * Returns the value of field comment_author_ip
     *
     * @return string
     */
    final public function getCommentatorIp(): ?string {
        return $this->commentator_ip;
    }

    /**
     * Returns the value of field comment_author_agent
     *
     * @return string
     */
    final public function getCommentatorBrowser(): ?string {
        return $this->commentator_browser;
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
     * Factory new comment for an article
     *
     * @param int $article_id
     * @param string $nickname
     * @return static
     */
    final public static function factory(int $article_id, string $nickname): self {
        $comment = new Comment();
        $comment->setArticleId($article_id);
        $comment->setCommentatorNickname($nickname);

        return $comment;
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
