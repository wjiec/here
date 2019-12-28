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
namespace Here\Tinder\Controller;

use Here\Model\Middleware\Article;
use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class ArticleController
 * @package Here\Tinder\Controller
 */
class ArticleController extends AbstractController {

    /**
     * Article view
     *
     * @param string $name The article name or id
     */
    public function indexAction(string $name) {
        $article = Article::findByAbbr($name) ?: Article::findById((int)$name);
        if ($article) {
            $this->tag::setTitle($article->getArticleTitle());
        }

        $article->incrArticleViewerCount();
        $this->view->setVars([
            'article' => $article,
        ]);
    }

}
