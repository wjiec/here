<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Controller;

use Here\Model\Article;
use Here\Model\ArticleCategory;
use Here\Model\Middleware\Category;
use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class CategoryController
 * @package Here\Tinder\Controller
 */
class CategoryController extends AbstractController {

    /**
     * Category view
     *
     * @param string $name
     */
    public function indexAction(string $name) {
        $category = Category::findByAbbr($name) ?: Category::findById((int)$name);
        if ($category) {
            $this->tag::setTitle($category->getCategoryName());

            $current = $this->getPaginationNumber();
            $page_size = $this->field->get('pagination.article.size', self::ARTICLES_IN_PAGE);
            $article_builder = $this->modelsManager->createBuilder()
                ->from(['ac' => ArticleCategory::class])
                ->columns(['a.article_title', 'a.article_abbr', 'a.article_outline', 'a.create_time'])
                ->join(Article::class, 'ac.article_id = a.article_id', 'a')
                ->where('ac.category_id = :category_id:', ['category_id' => $category->getCategoryId()])
                ->andWhere('a.article_public = :public_state:', ['public_state' => Article::BOOLEAN_TRUE])
                ->andWhere('a.article_publish = :publish_state:', ['publish_state' => Article::BOOLEAN_TRUE])
                ->orderBy('a.article_id desc')
                ->limit($page_size, $this->getPaginationOffset($page_size));
            $article_count = ArticleCategory::count(['category_id = ?0', 'bind' => [$category->getCategoryId()]]);

            $template = sprintf('%s?page={:page:}', $this->url->get(['for' => 'category', 'name' => $name]));
            $this->view->setVars([
                'category' => $category,
                'articles' => $article_builder->getQuery()->execute(),
                'pager' => container('pager', $current, $page_size, $article_count)->setTemplate($template)
            ]);
        }
    }



}
