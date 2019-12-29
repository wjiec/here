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

use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Library\Mvc\Model\AbstractModel;
use Phalcon\Mvc\Model\Resultset\Simple;


/**
 * Class Article
 * @package Here\Model
 *
 * @property Simple $categoryRelation
 * @method Simple getCategoryRelation($parameters = null)
 */
class Article extends AbstractModel {

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
     * @var string
     */
    protected $article_abbr;

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
     * @var integer
     */
    protected $article_like;

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
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('article');

        $this->hasMany('article_id', ArticleCategory::class, 'article_id', [
            'alias' => 'categoryRelation',
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

    /**
     * Method to set the value of field author_id
     *
     * @param integer $author_id
     * @return $this
     */
    public function setAuthorId(int $author_id) {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * Method to set the value of field article_title
     *
     * @param string $article_title
     * @return $this
     */
    public function setArticleTitle(string $article_title) {
        $this->article_title = $article_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleAbbr(): ?string {
        return $this->article_abbr;
    }

    /**
     * @param string $article_abbr
     * @return Article
     */
    public function setArticleAbbr(string $article_abbr) {
        $this->article_abbr = $article_abbr;
        return $this;
    }

    /**
     * Method to set the value of field article_outline
     *
     * @param string $article_outline
     * @return $this
     */
    public function setArticleOutline(string $article_outline) {
        $this->article_outline = $article_outline;
        return $this;
    }

    /**
     * Method to set the value of field article_body
     *
     * @param string $article_body
     * @return $this
     */
    public function setArticleBody(string $article_body) {
        $this->article_body = $article_body;
        return $this;
    }

    /**
     * Method to set the article for public
     *
     * @return $this
     */
    public function markArticlePublic() {
        $this->article_public = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article for private
     *
     * @return $this
     */
    public function markArticlePrivate() {
        $this->article_public = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to set the article to publish
     *
     * @return $this
     */
    public function markArticlePublish() {
        $this->article_publish = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article to drafted
     *
     * @return $this
     */
    public function markArticleDraft() {
        $this->article_publish = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to set the article allow comment
     *
     * @return $this
     */
    public function markArticleAllowComment() {
        $this->article_allow_comment = self::BOOLEAN_TRUE;
        return $this;
    }

    /**
     * Method to set the article allow comment
     *
     * @return $this
     */
    public function markArticleDisallowComment() {
        $this->article_allow_comment = self::BOOLEAN_FALSE;
        return $this;
    }

    /**
     * Method to increment like count for the article
     *
     * @return $this
     */
    public function incrArticleLikeCount() {
        $this->dml(/* @lang text */'update __table__ set article_like = article_like + 1');
        return $this;
    }

    /**
     * Method to increment viewers count for the article
     *
     * @return $this
     */
    public function incrArticleViewerCount() {
        $this->dml(/* @lang text */'update __table__ set article_view = article_view + 1');
        return $this;
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
    public function getArticleTitle(): ?string {
        return $this->article_title;
    }

    /**
     * Returns the value of field article_outline
     *
     * @return string
     */
    public function getArticleOutline(): ?string {
        return $this->article_outline;
    }

    /**
     * Returns the value of field article_body
     *
     * @return string
     */
    public function getArticleBody(): ?string {
        return $this->article_body;
    }

    /**
     * Returns the article public
     *
     * @return bool
     */
    public function isArticlePublic(): bool {
        return (int)$this->article_public === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article private
     *
     * @return bool
     */
    public function isArticlePrivate(): bool {
        return (int)$this->article_public === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the article published
     *
     * @return bool
     */
    public function isArticlePublished(): bool {
        return (int)$this->article_publish === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article drafted
     *
     * @return bool
     */
    public function isArticleDrafted(): bool {
        return (int)$this->article_publish === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the article allowed comment
     *
     * @return bool
     */
    public function isArticleAllowComment(): bool {
        return (int)$this->article_allow_comment === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the article disallowed comment
     *
     * @return bool
     */
    public function isArticleDisallowComment(): bool {
        return (int)$this->article_allow_comment === self::BOOLEAN_FALSE;
    }

    /**
     * Returns the value of field article_like
     *
     * @return integer
     */
    public function getArticleLike(): int {
        return (int)$this->article_like;
    }

    /**
     * Returns the value of field article_views
     *
     * @return integer
     */
    public function getArticleViews(): int {
        return (int)$this->article_view;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    public function getCreateTime(): ?string {
        return $this->create_time;
    }

    /**
     * Returns the value of field update_time
     *
     * @return string
     */
    public function getUpdateTime(): ?string {
        return $this->update_time;
    }

    /**
     * Publish the article
     *
     * @return bool
     * @throws ModelSaveException
     */
    public function publish(): bool {
        return $this->markArticlePublish()->save();
    }

    /**
     * Creates new article model
     *
     * @param int $author_id
     * @return static
     */
    public static function factory(int $author_id): self {
        $article = new static();
        $article->setAuthorId($author_id);

        return $article;
    }

}
