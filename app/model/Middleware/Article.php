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
namespace Here\Model\Middleware;

use Here\Library\Middleware\Adapter\Cache;
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
        return (new Cache())->setDefault("article:abbr:{$name}", function() use ($name) {
            return ArticleModel::findFirst([
                'conditions' => 'article_abbr = ?0',
                'bind' => [$name]
            ]);
        }, 3600);
    }

    /**
     * Returns the article when article_id matched, null otherwise
     *
     * @param int $id
     * @return ArticleModel|null
     */
    public static function findById(int $id): ?ArticleModel {
        return (new Cache())->setDefault("article:id:{$id}", function() use ($id) {
            return ArticleModel::findFirst($id);
        });
    }

}
