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
namespace Here\Tinder\Controller;

use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class SearchController
 * @package Here\Tinder\Controller
 */
class SearchController extends AbstractController {

    /**
     * Search something in blog
     */
    public function indexAction() {
        $search = $this->request->getPost('search', 'trim');
        if (!empty($search) && $this->security->checkToken()) {
            $this->tag::setTitle($search);
        }
    }

}
