<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Controller;

use Here\Model\Article;
use Here\Tinder\Library\Mvc\Controller;


/**
 * Class ExploreController
 *
 * @package Here\Tinder\Controller
 */
class ExploreController extends Controller {

    /**
     * explore articles, homepage
     */
    public function indexAction() {
        $articles = Article::query()
            ->where('article_publish = :publish:', ['publish' => Article::BOOLEAN_TRUE])
            ->orderBy('article_id desc');
        $this->view->setVar('articles', $articles->execute());
    }

}
