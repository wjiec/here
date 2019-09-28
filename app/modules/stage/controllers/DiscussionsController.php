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
        $this->view->setVars(array(
            'articles' => array(
                array(
                    'title' => 'article title 1',
                    'description' => 'article description 1',
                ),
                array(
                    'title' => 'article title 2',
                    'description' => 'article description 2',
                )
            )
        ));
    }

}
