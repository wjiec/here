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

use Here\Model\Article;
use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class ExploreController
 * @package Here\Tinder\Controller
 */
final class ExploreController extends AbstractController {

    /**
     * Shows the author info and hot article to views
     */
    final public function indexAction() {
        $page_size = $this->field->get('pagination.article.size', self::ARTICLES_IN_PAGE);
        $article_builder = $this->modelsManager->createBuilder()
            ->from(Article::class)
            ->orderBy('article_id desc')
            ->limit($page_size, $this->getPaginationOffset($page_size));

        $this->view->setVars([
            'articles' => $article_builder->getQuery()->execute(),
            'pager' => container('pager', $page_size, Article::count())
                ->setTemplate(sprintf('%s?page={:page}', $this->url->get(['for' => 'explore'])))
        ]);
    }

    /**
     * @const ARTICLES_IN_PAGE The number of the articles per page
     */
    protected const ARTICLES_IN_PAGE = 10;

}
