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
namespace Here\Admin\Controller;

use Here\Admin\Library\Mvc\Controller\AbstractController;


/**
 * Class SetupController
 * @package Here\Admin\Controller
 */
final class SetupController extends AbstractController {

    /**
     * Sets the title of the setup-wizard
     */
    final public function initialize() {
        parent::initialize();

        $this->tag::setTitle('SetupWizard');
        if (container('wizard')->isInitialized()) {
            return $this->response->redirect(array('for' => 'discussion'));
        }
    }

    /**
     * Setups the administrator
     */
    final public function indexAction() {}

}
