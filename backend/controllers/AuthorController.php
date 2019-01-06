<?php
/**
 * AuthorController
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers;


use Here\Controllers\Base\SecurityControllerBase;
use Here\Libraries\Redis\RedisExpireTime;
use Here\Libraries\Redis\RedisGetter;
use Here\Libraries\Redis\RedisKeys;
use Here\Models\Authors;


/**
 * Class BloggerController
 * @package Here\controllers
 */
final class AuthorController extends SecurityControllerBase {

    /**
     * initializing blogger account and blog info
     */
    final public function createAction() {
        // author exists and terminal request
        if ($this->getCachedAuthor()) {
            $this->makeResponse(self::STATUS_FATAL_ERROR, $this->t->_('register_closed'));
            $this->terminalByStatusCode(403);
        }

        try {
            // check author request correct
            if (!$this->checkAuthorInfo($this->request->getEncrypted())) {
                throw new \Exception($this->t->_('register_info_incorrect'));
            }
            // generate author info
            if (!$this->generateAuthor($this->request->getEncrypted())) {
                throw new \Exception($this->t->_('register_info_incorrect'));
            }

            // refresh author cache
            (new RedisGetter())->refresh(RedisKeys::getAuthorRedisKey(), function() {
                return Authors::findFirst();
            }, RedisExpireTime::NO_EXPIRE);

            // completed
            return $this->makeResponse(self::STATUS_SUCCESS, null, array(
                'welcome' => $this->t->_('register_complete')
            ));
        } catch (\Exception $e) {
            return $this->makeResponse(self::STATUS_AUTHOR_VALIDATE_ERROR, $e->getMessage());
        }
    }

    /**
     * @param array $author_data
     * @return bool
     */
    final private function checkAuthorInfo(array $author_data): bool {
        // email validate
        if (!filter_var($author_data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        // username validate
        if (!preg_match('/\w+/', $author_data['username'])) {
            return false;
        }
        // password validate
        if (preg_match('/\s+/', $author_data['password'])) {
            return false;
        }
        return true;
    }

    /**
     * @param array $author_data
     * @return bool
     */
    final private function generateAuthor(array $author_data): bool {
        $author = new Authors();
        $author->email = $author_data['email'];
        $author->username = $author_data['username'];
        $author->password = password_hash($author_data['password'], PASSWORD_DEFAULT);
        $author->nickname = $author_data['username'];
        $author->last_login_ip_address = $this->request->getClientAddress(true);
        return $author->save();
    }

    private const STATUS_AUTHOR_VALIDATE_ERROR = 0x1000;

}
