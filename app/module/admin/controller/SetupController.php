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
use Here\Library\Article\Factory;
use Here\Model\Category;
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
        if (container('environment', 'production')) {
            $this->view->cache(['key' => 'setup-wizard']);
        }
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
            $this->db->begin();
            /** @var Administrator $administrator */
            $administrator = container('administrator');

            // Create author
            $username = $this->request->getPost('username', 'trim');
            $password = $this->request->getPost('password', 'trim');
            $email = $this->request->getPost('email', 'trim');
            $author = $administrator->create($username, $password, $email);

            // Create default category
            $category = Category::factory('Default');
            $category->save();

            // Create draft of article and save
            $draft = (new Factory($author))->createFromFile(docs_path('/template/initial.md'));
            $draft->setTitle('Hello World');
            $draft->addCategory($category);
            $draft->save();

            /* comments */

            $this->db->commit();
            return $this->response->redirect(['for' => 'explore']);
        } catch (Throwable $e) {
            $this->db->rollback();
            $this->view->setVar('error_message', $e->getMessage());
        }
    }

}
