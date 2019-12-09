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

use Exception;
use Here\Admin\Library\Mvc\Controller\AbstractController;
use Here\Library\Creation\Article\Factory;
use Here\Library\Creation\Comment\Commentator;
use Here\Model\Category;
use Here\Provider\Administrator\Administrator;
use Throwable;


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

        if (container('administrator')->exists()) {
            $this->response->redirect(['for' => 'explore']);
        }
    }

    /**
     * Setups the administrator
     */
    final public function indexAction() {}

    /**
     * Completed the administrator register
     */
    final public function completeAction() {
        if (!$this->security->checkToken()) {
            return $this->response->redirect(['for' => 'setup-wizard']);
        }

        try {
            $this->db->begin();

            $username = $this->request->getPost('username', 'trim');
            $password = $this->request->getPost('password', 'trim');
            $email = $this->request->getPost('email', 'trim');
            if (!$username || !$password) {
                throw new Exception($this->translator->_('setup_form_submit_invalid'));
            }

            /** @var Administrator $administrator */
            $administrator = container('administrator');
            $author = $administrator->create($username, $password, $email);

            // Create default category
            $category = Category::factory($this->translator->_('category_default_name'));
            $category->save();

            // Create draft of article and save
            $draft = (new Factory($author))->createFromFile(doc_path('/template/initial.md'));
            $draft->addCategory($category);
            $draft->publish();

            // Create comments under the article
            (new Commentator('Jayson'))->comment($draft->getArticleId(), 'Congratulations~');
            (new Commentator('Parrot'))->comment($draft->getArticleId(), 'The same to above');

            $this->db->commit();
            return $this->response->redirect(['for' => 'explore']);
        } catch (Throwable $e) {
            $this->db->rollback();
            $this->view->setVar('error_message', $e->getMessage());
            $this->view->setVar('error_stacktrace', $e->getTraceAsString());
        }
    }

}
