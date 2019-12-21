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

use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class FeedController
 * @package Here\Tinder\Controller
 */
class FeedController extends AbstractController {

    /**
     * Closed view renderer
     */
    public function initialize() {
        parent::initialize();

        $this->view->disable();
    }

    /**
     * Rss subscribe
     */
    public function indexAction() {
        $this->response->setContentType('application/atom+xml;charset=UTF-8');
        return $this->response->setContent(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<feed xmlns="http://www.w3.org/2005/Atom">' .
                "<title>{$this->administrator->model()->author_nickname}</title>" .
                '<entry></entry>' .
            '</feed>'
        );
    }

}
