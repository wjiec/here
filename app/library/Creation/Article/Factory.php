<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Creation\Article;

use Here\Model\Article;
use Here\Model\Author;


/**
 * Class Factory
 * @package Here\Library\Creation\Article
 */
class Factory {

    /**
     * The author of the article
     *
     * @var Author
     */
    protected $author;

    /**
     * Factory constructor.
     * @param Author $author
     */
    final public function __construct(Author $author) {
        $this->author = $author;
    }

    /**
     * Creates article from raw contents
     *
     * @param string $contents
     * @return Draft
     */
    final public function create(string $contents): Draft {
        return (new Draft($this->author))->setContents($contents);
    }

    /**
     * Creates article from file
     *
     * @param string $filename
     * @return Draft|null
     */
    final public function createFromFile(string $filename): ?Draft {
        if (!is_file($filename)) {
            return null;
        }
        return $this->create(file_get_contents($filename));
    }

    /**
     * Load article from database
     *
     * @param Article $article
     * @return Draft
     */
    final public function load(Article $article): Draft {
        return new Draft($this->author, $article);
    }

}
