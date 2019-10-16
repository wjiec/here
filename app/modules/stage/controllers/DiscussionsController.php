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
namespace Here\Stage\Controllers;

use Here\Models\Article;


/**
 * Class DiscussionsController
 * @package Here\Stage\Controllers
 */
final class DiscussionsController extends ControllerBase {

    /**
     * Shows latest articles
     */
    final public function indexAction() {
        $this->tag->setTitle("Homepage");
        $this->view->setVar('articles', Article::find());
    }

}
