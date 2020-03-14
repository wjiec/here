<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Creation\Comment;


use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Library\Validator\Adapter\Inet;
use Here\Model\Comment;

/**
 * Class Commentator
 * @package Here\Library\Creation\Comment
 */
class Commentator {

    /**
     * The name of the commentator
     *
     * @var string
     */
    protected $nickname;

    /**
     * The email of the commentator
     *
     * @var string
     */
    protected $email;

    /**
     * The user-agent of the commentator from
     *
     * @var string
     */
    protected $browser;

    /**
     * The ip-address of the commentator from
     *
     * @var string
     */
    protected $ip_address;

    /**
     * Commentator constructor.
     * @param string $nickname
     */
    public function __construct(string $nickname) {
        $this->nickname = $nickname;
        $this->email = '';
        $this->browser = '';
        $this->ip_address = '';
    }

    /**
     * Sets the commentator email address
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Sets the commentator source
     *
     * @param string $browser
     * @param string $ip_address
     * @return $this
     */
    public function setSource(string $browser, string $ip_address): self {
        $this->browser = $browser;
        $this->ip_address = $ip_address;
        return $this;
    }

    /**
     * Comment something text to the article
     *
     * @param int $article_id
     * @param string $content
     * @return bool
     * @throws ModelSaveException
     */
    public function comment(int $article_id, string $content): bool {
        if (!$article_id || empty($content)) {
            return false;
        }

        $comment = Comment::factory($article_id, $this->nickname);
        $comment->setCommentBody($content);
        $comment->setCommentatorEmail($this->email);
        $comment->setCommentatorBrowser($this->browser);
        if ((new Inet())->validate($this->ip_address)) {
            $comment->setCommentatorIp($this->ip_address);
        }

        return $comment->save();
    }

}
