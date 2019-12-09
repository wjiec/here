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
namespace Here\Library\Creation\Article;

use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Library\Utils\Text;
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
            $translator = container('translator');
            $this->article = Article::factory($author->getAuthorId(), $translator->_('untitled_article'));
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
     */
    public function publish(): bool {
        $this->ensureArticleBody();
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
     */
    private function ensureArticleBody() {
        $this->article->setArticleBody(Text::normalize($this->article->getArticleBody()));
        $this->article->setArticleOutline(Text::normalize($this->article->getArticleOutline()));
    }

    /**
     * @const OUTLINE_MAX_LINES
     */
    protected const OUTLINE_MAX_LINES = 8;

}
