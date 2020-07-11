<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Blogger;

use Here\Library\Blogger\Blog\Blog;
use Here\Model\Article;
use Here\Model\Author;
use Here\Provider\Blogger\CacheKey;


/**
 * Class Writer
 *
 * @package Here\Library\Blogger
 */
class Writer {

    /**
     * The author
     *
     * @var Author
     */
    protected $author;

    /**
     * Writer constructor.
     *
     * @param Author $author
     */
    public function __construct(Author $author) {
        $this->author = $author;
    }

    /**
     *  Create a blog from file
     *
     * @param string $filename
     * @param Author $author
     * @return static
     */
    public static function fromFile(string $filename, Author $author) {
        return new static($author);
    }

    /**
     * get blog instance
     *
     * @param Article $article
     * @return Blog
     */
    public function write(Article $article) {
        return new Blog($article);
    }

}
