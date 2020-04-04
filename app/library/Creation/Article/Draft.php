<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Creation\Article;

use Bops\Exception\Framework\Mvc\Model\ModelSaveException;
use Here\Library\Creation\Article\Metadata\Parser;
use Here\Library\Exception\Metadata\MetadataParseException;
use Here\Model\Article;
use Here\Model\ArticleCategory;
use Here\Model\Author;
use Here\Model\Category;


/**
 * Class Article
 * @package Here\Library\Article
 */
final class Draft {

    /**
     * The author of the article
     *
     * @var Author
     */
    protected $author;

    /**
     * @var Article
     */
    protected $article;

    /**
     * @var int[]
     */
    protected $categories;

    /**
     * Article constructor.
     * @param Author $author
     * @param Article|null $article
     */
    public function __construct(Author $author, ?Article $article = null) {
        $this->author = $author;
        $this->article = $article;
        $this->categories = [];

        if (!$this->article) {
            $this->article = Article::factory($author->getAuthorId());
        }
    }

    /**
     * @return int
     */
    public function getArticleId(): int {
        return $this->article->getArticleId();
    }

    /**
     * Sets contents of the article
     *
     * @param string $contents
     * @return $this
     */
    public function setContents(string $contents): self {
        $this->article->setArticleBody($contents);
        return $this;
    }

    /**
     * Sets title of the article
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self {
        $this->article->setArticleTitle($title);
        return $this;
    }

    /**
     * Adds the article into a category
     *
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category): self {
        $this->categories[] = $category->getCategoryId();
        return $this;
    }

    /**
     * Saves the article and other related contents into database
     *
     * @return bool
     * @throws ModelSaveException
     * @throws ModelSaveException
     * @throws MetadataParseException
     */
    public function publish(): bool {
        $this->ensureArticleMetadata();
        $this->article->publish();

        foreach ($this->categories as $category_id) {
            ArticleCategory::factory($this->article->getArticleId(), $category_id)->save();
        }

        return true;
    }

    /**
     * Ensure the body of article normalize
     *  * end of lf
     *  * tail blank
     *
     * @throws MetadataParseException
     */
    private function ensureArticleMetadata() {
        $metadata = Parser::parse($this->article->getArticleBody());
        if (empty($this->article->getArticleTitle() && $metadata->title)) {
            $this->article->setArticleTitle($metadata->title);
        }
        if (empty($this->article->getArticleOutline()) && $metadata->outline) {
            $this->article->setArticleOutline($metadata->outline);
        }
        if (empty($this->article->getArticleAbbr()) && $metadata->abbr) {
            $this->article->setArticleAbbr($metadata->abbr);
        }
        if ($metadata->access_private) {
            $this->article->markArticlePrivate();
        }
        if ($metadata->disallow_comment) {
            $this->article->markArticleDisallowComment();
        }
        $this->article->setArticleBody($metadata->body);
    }

}
