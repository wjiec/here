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
namespace Here\Admin\Controller;

use Here\Admin\Library\Mvc\Controller\AbstractController;
use Here\Provider\Administrator\Administrator;
use Phalcon\Http\ResponseInterface;
use Throwable;


/**
 * Class SetupController
 * @package Here\Admin\Controller
 */
final class SetupController extends AbstractController {

    /**
     * Sets the title of the setup-wizard
     *
     * @return ResponseInterface|void
     */
    final public function initialize() {
        parent::initialize();

        if (container('administrator')->exists()) {
            return $this->response->redirect(['for' => 'explore']);
        }
    }

    /**
     * Setups the administrator
     */
    final public function indexAction() {
        $this->tag::setTitle($this->translator->_('setup_wizard'));
//        $this->view->cache(['key' => 'setup-wizard']);
    }

    /**
     * Completed the administrator register
     */
    final public function completeAction() {
        $this->tag::setTitle($this->translator->_('setup_complete'));
        if (!$this->security->checkToken()) {
            return $this->response->redirect(['for' => 'setup-wizard']);
        }

        try {
            /** @var Administrator $administrator */
            $administrator = container('administrator');

            $username = $this->request->getPost('username', 'trim');
            $password = $this->request->getPost('password', 'trim');
            $email = $this->request->getPost('email', 'trim');
            $author = $administrator->create($username, $password, $email);

            return $this->response->redirect(['for' => 'explorer']);
        } catch (Throwable $e) {
            $this->view->setVar('error_message', $e->getMessage());
        }
    }

}
