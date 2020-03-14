<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model\Middleware;

use Here\Model\Article as ArticleModel;


/**
 * Class Article
 * @package Here\Model\Middleware
 */
class Article {

    /**
     * Returns the article when article_abbr matched, null otherwise
     *
     * @param string $name
     * @return ArticleModel|null
     */
    public static function findByAbbr(string $name): ?ArticleModel {
        return ArticleModel::findFirst([
            'conditions' => 'article_abbr = ?0',
            'bind' => [$name]
        ]);
    }

    /**
     * Returns the article when article_id matched, null otherwise
     *
     * @param int $id
     * @return ArticleModel|null
     */
    public static function findById(int $id): ?ArticleModel {
        return ArticleModel::findFirst($id);
    }

}
