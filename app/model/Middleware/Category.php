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

use Here\Model\Category as CategoryModel;


/**
 * Class Category
 * @package Here\Model\Middleware
 */
class Category {

    /**
     * Returns the category when category_abbr matched, null otherwise
     *
     * @param string $abbr
     * @return CategoryModel|null
     */
    public static function findByAbbr(string $abbr): ?CategoryModel {
        return CategoryModel::findFirst([
            'conditions' => 'category_abbr = ?0',
            'bind' => [$abbr]
        ]);
    }

    /**
     * Returns the category when category_id matched, null otherwise
     *
     * @param int $id
     * @return CategoryModel|null
     */
    public static function findById(int $id): ?CategoryModel {
        return CategoryModel::findFirst($id);
    }

}
