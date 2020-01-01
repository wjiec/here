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
namespace Here\Tinder\Controller;

use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Model\Comment;
use Here\Model\Middleware\Article;
use Here\Tinder\Library\Mvc\Controller\AbstractController;
use Phalcon\Http\ResponseInterface;


/**
 * Class ArticleController
 * @package Here\Tinder\Controller
 */
class ArticleController extends AbstractController {

    /**
     * Article view
     *
     * @param string $name The article name or id
     */
    public function indexAction(string $name) {
        $article = Article::findByAbbr($name) ?: Article::findById((int)$name);
        if ($article && $article->isArticlePublic() && $article->isArticlePublished()) {
            $this->tag::setTitle($article->getArticleTitle());

            $article->incrArticleViewerCount();
            $this->view->setVars([
                'article' => $article,
            ]);
        }
    }

    /**
     * Adds article comment
     *
     * @return ResponseInterface|void
     */
    public function commentAction() {
        if (!$this->security->checkToken()) {
            $this->view->setVar('error_message', _t('error_message_invalid_token'));
            return;
        }

        $article_id = $this->request->getPost('article_id', 'int!', 0);
        $email = $this->request->getPost('email', 'trim');
        $nickname = $this->request->getPost('nickname', 'trim');
        $content = $this->request->getPost('comment', 'trim');
        if (!$article_id || !$email || !$nickname || !$content) {
            $this->view->setVar('error_message', _t('error_message_invalid_params'));
            return;
        }

        $article = Article::findById($article_id);
        if (!$article) {
            $this->view->setVar('error_message', _t('error_message_article_not_found'));
            return;
        }

        try {
            $comment = Comment::factory($article_id, $nickname);
            $comment->setCommentatorEmail($email);
            $comment->setCommentBody($content);
            $comment->setCommentatorIp($this->request->getClientAddress(true));
            $comment->setCommentatorBrowser($this->request->getUserAgent());
            $comment->setCommentParent($this->request->getPost('parent_id', 'int!', 0));
            $comment->save();

            return $this->response->redirect(['for' => 'article', 'name' => $article->getArticleAbbr()]);
        } catch (ModelSaveException $e) {
            container('logger')->error("AddComment: {$e->getMessage()}");
            $this->view->setVar('error_message', _t('error_message_save_failure'));
        }
    }

}
