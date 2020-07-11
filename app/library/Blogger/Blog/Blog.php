<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Blogger\Blog;


use Here\Model\Article;

/**
 * Class Blog
 *
 * @package Here\Library\Blogger\Blog
 */
class Blog {

    /**
     * @var Article
     */
    protected $article;

    /**
     * Blog constructor.
     *
     * @param Article $article
     */
    public function __construct(Article $article) {
        $this->article = $article;
    }

    /**
     * Save blog into database
     */
    public function save() {
    }

    /**
     * Publish blog
     */
    public function publish() {
    }

}
