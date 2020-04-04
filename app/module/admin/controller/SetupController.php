<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin\Controller;

use Exception;
use Here\Library\Creation\Article\Factory;
use Here\Library\Creation\Comment\Commentator;
use Here\Library\Mvc\Controller\AbstractController;
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
     * @throws Exception
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
     *
     * @return ResponseInterface|void
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
                throw new Exception(_t('setup_form_submit_invalid'));
            }

            /** @var Administrator $administrator */
            $administrator = container('administrator');
            $author = $administrator->create($username, $password, $email);

            // Create default category
            $category = Category::factory(_t('category_default_name'), 'default');
            $category->save();

            // Create draft of article and save
            $file = container('navigator')->rootDir('/docs//template/initial.md');
            $draft = (new Factory($author))->createFromFile($file);
            $draft->addCategory($category);
            $draft->publish();

            // Create comments under the article
            (new Commentator('Jayson'))->comment($draft->getArticleId(), 'Congratulations~');
            (new Commentator('Parrot'))->comment($draft->getArticleId(), 'The same to above');

            $this->db->commit();
            $administrator->rebuild();
            return $this->response->redirect(['for' => 'explore']);
        } catch (Throwable $e) {
            $this->db->rollback();
            $this->view->setVar('error_message', $e->getMessage());
            $this->view->setVar('error_stacktrace', $e->getTraceAsString());
        }
    }

}
