<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin\Controller;

use Here\Admin\Library\Mvc\Controller;
use Phalcon\Http\ResponseInterface;


/**
 * Class SetupController
 *
 * @package Here\Admin\Controller
 */
class SetupController extends Controller {

    /**
     * redirect to homepage when blogger initialized
     *
     * @return ResponseInterface|void
     */
    public function initialize() {
        parent::initialize();
        if ($this->blogger) {
            return $this->response->redirect(['for' => 'explore']);
        }
    }

    /**
     * setup blog page
     */
    public function indexAction() {}

    /**
     * save blogger into db and flush cache, while generate first blog
     */
    public function completeAction() {
        var_dump($this->request->get());
    }

}
