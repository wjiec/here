<?php
/**
 * BloggerController.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers;


use Here\Libraries\Redis\RedisGetter;
use Here\Libraries\Redis\RedisKeys;
use Here\Libraries\RSA\RSAError;
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
        // author created and terminal request
        if ($this->getCachedAuthor() !== null) {
            $this->terminalByStatusCode(403);
        }

        $raw_params = $this->request->getRawBody();
        // using rsa-object decrypt user-data
        $rsa_object = $this->getCachedRSAObject();

        try {
            // decrypt by private key
            $author = json_decode($rsa_object->decrypt($raw_params), true);
            // check author data invalid
            if (!is_array($author) || !$this->checkAuthorInfo($author)) {
                throw new \Exception($this->translator->AUTHOR_REGISTER_INCORRECT);
            }

            // generate author info
            if (!$this->generateAuthor($author)) {
                throw new \Exception($this->translator->AUTHOR_REGISTER_INCORRECT);
            }

            // refresh author cache
            (new RedisGetter())->refresh(RedisKeys::getAuthorRedisKey(), function() {
                return Authors::findFirst();
            }, RedisGetter::NO_EXPIRE);

            // completed
            return $this->makeResponse(self::STATUS_SUCCESS, null, array(
                'welcome' => $this->translator->AUTHOR_REGISTER_WELCOME
            ));
        } catch (RSAError $e) {
            return $this->makeResponse(self::STATUS_AUTHOR_REGISTER_INVALID,
                $this->translator->AUTHOR_REGISTER_INVALID);
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
        $author->last_login_ip_address = $this->request->getClientAddress();
        return $author->save();
    }

    private const STATUS_AUTHOR_VALIDATE_ERROR = 0x1000;

    private const STATUS_AUTHOR_REGISTER_INVALID = 0x1001;

}
