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
namespace Here\Tinder\Library\Mvc\Controller;

use Here\Library\Mvc\Controller\AbstractController as MvcAbstractController;
use Phalcon\Http\ResponseInterface;


/**
 * Class AbstractController
 * @package Here\Tinder\Library\Mvc\Controller
 */
abstract class AbstractController extends MvcAbstractController {

    /**
     * Setups the administrator for application when
     * administrator has not loaded
     *
     * @return ResponseInterface
     */
    public function initialize() {
        // Redirect to initializing page when administrator not loaded
        if (!container('wizard')->isInitialized()) {
            return $this->response->redirect(array('for' => 'setup-wizard'));
        }
    }

}
