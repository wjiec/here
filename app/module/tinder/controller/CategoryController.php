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
        $this->view->setVars([
            'category' => $category
        ]);
    }

}
