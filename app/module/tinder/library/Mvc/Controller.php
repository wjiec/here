<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Library\Mvc;

use Here\Library\Mvc\Controller as HereController;
use Phalcon\Http\ResponseInterface;


/**
 * Class Controller
 *
 * @package Here\Tinder\Library\Mvc
 */
class Controller extends HereController {

    /**
     * initializing titles and checks blog author inits
     *
     * @return ResponseInterface|void
     */
    public function initialize() {
        parent::initialize();
        if (!$this->blogger) {
            return $this->response->redirect(['for' => 'setup-wizard']);
        }
    }

}
