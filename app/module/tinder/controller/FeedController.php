<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Controller;

use Exception;
use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class FeedController
 * @package Here\Tinder\Controller
 */
class FeedController extends AbstractController {

    /**
     * Closed view renderer
     *
     * @throws Exception
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
