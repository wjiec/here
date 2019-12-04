<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Model;

use Here\Library\Mvc\Model\AbstractModel;


/**
 * Class Article
 * @package Here\Model
 */
final class Article extends AbstractModel {

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
    protected $article_body;

    /**
     *
     * @var string
     */
    protected $article_public;

    /**
     *
     * @var string
     */
    protected $article_publish;

    /**
     *
     * @var string
     */
    protected $article_allow_comment;

    /**
     *
     * @var string
     */
    protected $article_lock;

    /**
     *
     * @var string
     */
    protected $article_password;

    /**
     *
     * @var integer
     */
    protected $article_like;

    /**
     *
     * @var integer
     */
    protected $article_comments;

    /**
     *
     * @var integer
     */
    protected $article_views;

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
     * Method to set the value of field author_id
     *
     * @param integer $author_id
     * @return $this
     */
    final public function setAuthorId(int $author_id) {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * Method to set the value of field article_title
     *
     * @param string $article_title
     * @return $this
     */
    final public function setArticleTitle(string $article_title) {
        $this->article_title = $article_title;
        return $this;
    }

    /**
     * Method to set the value of field article_outline
     *
     * @param string $article_outline
     * @return $this
     */
    final public function setArticleOutline(string $article_outline) {
        $this->article_outline = $article_outline;
        return $this;
    }

    /**
     * Method to set the value of field article_body
     *
     * @param string $article_body
     * @return $this
     */
    final public function setArticleBody(string $article_body) {
        $this->article_body = $article_body;
        return $this;
    }

    /**
     * Method to set the article for public
     *
     * @return $this
     */
    final public function markArticlePublic() {
        $this->article_public = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article for private
     *
     * @return $this
     */
    final public function markArticlePrivate() {
        $this->article_public = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to set the article to publish
     *
     * @return $this
     */
    final public function markArticlePublish() {
        $this->article_publish = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article to drafted
     *
     * @return $this
     */
    final public function markArticleDraft() {
        $this->article_publish = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to set the article allow comment
     *
     * @return $this
     */
    final public function markArticleAllowComment() {
        $this->article_allow_comment = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article allow comment
     *
     * @return $this
     */
    final public function markArticleDisallowComment() {
        $this->article_allow_comment = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to set the article unlock
     *
     * @return $this
     */
    final public function unlockArticle() {
        $this->article_lock = self::ARTICLE_LOCK_NEVER;
        $this->article_password = '';
        return $this;
    }

    /**
     * Method to lock the article for everybody without owner
     *
     * @param string $password
     * @return $this
     */
    final public function lockArticleWithoutOwner(string $password) {
        $this->article_lock = self::ARTICLE_LOCK_OWNER;
        $this->article_password = $password;
        return $this;
    }

    /**
     * Method to lock the article for everybody
     *
     * @param string $password
     * @return $this
     */
    final public function lockArticleEverybody(string $password) {
        $this->article_lock = self::ARTICLE_LOCK_ALWAYS;
        $this->article_password = $password;
        return $this;
    }

    /**
     * Method to increment like count for the article
     *
     * @return $this
     */
    final public function incrArticleLikeCount() {
        $this->article_like = (int)$this->article_like + 1;
        return $this;
    }

    /**
     * Method to increment comments count for the article
     *
     * @return $this
     */
    final public function incrArticleCommentCount() {
        $this->article_comments = (int)$this->article_comments + 1;
        return $this;
    }

    /**
     * Method to increment viewers count for the article
     *
     * @return $this
     */
    final public function incrArticleViewerCount() {
        $this->article_views = (int)$this->article_views + 1;
        return $this;
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
     * Returns the value of field author_id
     *
     * @return integer
     */
    final public function getAuthorId() {
        return (int)$this->author_id;
    }

    /**
     * Returns the value of field article_title
     *
     * @return string
     */
    final public function getArticleTitle(): ?string {
        return $this->article_title;
    }

    /**
     * Returns the value of field article_outline
     *
     * @return string
     */
    final public function getArticleOutline(): ?string {
        return $this->article_outline;
    }

    /**
     * Returns the value of field article_body
     *
     * @return string
     */
    final public function getArticleBody(): ?string {
        return $this->article_body;
    }

    /**
     * Returns the article public
     *
     * @return bool
     */
    final public function isArticlePublic(): bool {
        return (int)$this->article_public === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article private
     *
     * @return bool
     */
    final public function isArticlePrivate(): bool {
        return (int)$this->article_public === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the article published
     *
     * @return bool
     */
    final public function isArticlePublished(): bool {
        return (int)$this->article_publish === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article drafted
     *
     * @return bool
     */
    final public function isArticleDrafted(): bool {
        return (int)$this->article_publish === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the article allowed comment
     *
     * @return bool
     */
    final public function isArticleAllowComment(): bool {
        return (int)$this->article_allow_comment === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article disallowed comment
     *
     * @return bool
     */
    final public function isArticleDisallowComment(): bool {
        return (int)$this->article_allow_comment === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the article lock status equals to never
     *
     * @return bool
     */
    final public function isArticleUnlocked(): bool {
        return is_null($this->article_lock) ||
            $this->article_lock === self::ARTICLE_LOCK_NEVER;
    }

    /**
     * Returns the article lock status equals to owner
     *
     * @return bool
     */
    final public function isArticleLockWithoutOwner(): bool {
        return $this->article_lock === self::ARTICLE_LOCK_OWNER;
    }

    /**
     * Returns the article lock status equals to always
     *
     * @return bool
     */
    final public function isArticleLocked(): bool {
        return $this->article_lock === self::ARTICLE_LOCK_ALWAYS;
    }

    /**
     * Returns the value of field article_password
     *
     * @return string
     */
    final public function getArticlePassword(): ?string {
        return $this->article_password;
    }

    /**
     * Returns the value of field article_like
     *
     * @return integer
     */
    final public function getArticleLike(): int {
        return (int)$this->article_like;
    }

    /**
     * Returns the value of field article_comments
     *
     * @return integer
     */
    final public function getArticleComments(): int {
        return (int)$this->article_comments;
    }

    /**
     * Returns the value of field article_views
     *
     * @return integer
     */
    final public function getArticleViews(): int {
        return (int)$this->article_views;
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
     * Returns the value of field update_time
     *
     * @return string
     */
    final public function getUpdateTime(): ?string {
        return $this->update_time;
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('article');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'article';
    }

    /**
     * Creates new article model
     *
     * @param int $author_id
     * @param string $title
     * @return static
     */
    final public static function factory(int $author_id, string $title): self {
        $article = new static();
        $article->setAuthorId($author_id);
        $article->setArticleTitle($title);

        return $article;
    }

    /**
     * Lock article never
     */
    public const ARTICLE_LOCK_NEVER = 'never';

    /**
     * Lock article and view by owner only
     */
    public const ARTICLE_LOCK_OWNER = 'owner';

    /**
     * Lock article for everybody
     */
    public const ARTICLE_LOCK_ALWAYS = 'always';

}
