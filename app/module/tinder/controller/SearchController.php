<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
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
