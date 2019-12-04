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
namespace Here\Library\Article;

use Here\Model\Author;


/**
 * Class Factory
 * @package Here\Library\Article
 */
final class Factory {

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

}
