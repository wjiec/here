<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin\Controller;

use Here\Admin\Library\Mvc\Controller;
use Here\Library\Blogger\Writer;
use Here\Library\Field\Cleaner;
use Here\Model\Article;
use Here\Model\Author;
use Here\Provider\Blogger\CacheKey;
use Phalcon\Http\ResponseInterface;
use Throwable;


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
    public function indexAction() {
        if ($error = $this->request->getPost('error', 'trim')) {
            $this->view->setVar('errorMessage', $error);
        }
    }

    /**
     * save blogger into db and flush cache, while generate first blog
     */
    public function completeAction() {
        if (!$this->security->checkToken()) {
            $this->setTitleI18n('title_forbidden');
            return $this->view->setVars([
                'errorMessage' => _t('error_csrf_incorrect'),
                'errorRedirect' => _url(['for' => 'setup-wizard'])
            ]);
        }

        $username = $this->request->getPost('username', 'trim');
        $password = $this->request->getPost('password', 'trim');
        if (!$username || !$password) {
            return $this->view->setVars([
                'errorMessage' => _t('error_blogger_incorrect'),
                'errorRedirect' => _url(['for' => 'setup-wizard'])
            ]);
        }

        try {
            // save author
            $blogger = new Author();
            $blogger->setAuthorUsername($username);
            $blogger->setAuthorPassword(password_hash($password, PASSWORD_DEFAULT));
            $blogger->setAuthorNickname($username);
            $blogger->save();

            // clean blogger
            Cleaner::fromAll(CacheKey::BLOGGER_CACHE_KEY);

            // initial first blog
            Writer::fromFile(container('navigator')->rootDir('docs/template/helloworld.md'), $blogger)
                ->write(new Article())->publish();
        } catch (Throwable $e) {
            return $this->view->setVars([
                'errorMessage' => $e->getMessage(),
                'errorRedirect' => _url(['for' => 'setup-wizard'])
            ]);
        }

        return $this->response->redirect(['for' => 'explore']);
    }

}
