<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Model\Middleware;

use Here\Library\Middleware\Adapter\Cache;
use Here\Model\Author as AuthorModel;


/**
 * Class Author
 * @package Here\Model\Middleware
 */
class Author {

    /**
     * Returns the author from cache and database when
     * cache not found anything
     *
     * @return AuthorModel|null
     */
    public static function findFist(): ?AuthorModel {
        return (new Cache())->setDefault(":model:author:FIRST", function() {
            return AuthorModel::findFirst();
        });
    }

}
