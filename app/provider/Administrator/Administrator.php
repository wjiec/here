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
namespace Here\Provider\Administrator;

use Here\Library\Exception\Mvc\ModelSaveException;
use Here\Model\Author as AuthorModel;
use Here\Model\Middleware\Author;
use Phalcon\Http\CookieInterface;
use Phalcon\Http\Request;
use Phalcon\Http\Response\Cookies;
use function Here\Library\Xet\base64_decode_safe;
use function Here\Library\Xet\base64_encode_safe;
use function Here\Library\Xet\current_date;


/**
 * Class Administrator
 * @package Here\Provider\Administrator
 */
final class Administrator {

    /**
     * @var AuthorModel
     */
    private $author;

    /**
     * Initializing the administrator from cache and database
     */
    public function __construct() {
        $this->author = Author::findFist();
    }

    /**
     * Returns model of the author
     *
     * @return AuthorModel
     */
    public function model(): AuthorModel {
        return $this->author;
    }

    /**
     * Create an administrator from username, email and password
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return AuthorModel
     * @throws ModelSaveException
     */
    public function create(string $username, string $password, string $email): AuthorModel {
        $this->author = AuthorModel::factory($username, $password);
        $this->author->setAuthorEmail($email);
        $this->saveLoginInfo();

        return $this->author;
    }

    /**
     * Returns true when author exists, false otherwise
     *
     * @return bool
     */
    public function exists(): bool {
        return $this->author !== null;
    }

    /**
     * Rebuild the authors and returns it
     *
     * @return AuthorModel
     */
    public function rebuild(): AuthorModel {
        $this->author = Author::findFist(true);
        return $this->author;
    }

    /**
     * Check login from token in the cookie
     *
     * @return bool
     */
    public function loginFromToken(): bool {
        if (!container('session')->has(self::TOKEN_IN_SESSION_NAME)) {
            /* @var $cookie CookieInterface */
            $cookie = container('cookies')->get(self::TOKEN_IN_COOKIE_NAME);
            if (!$cookie || !$cookie->getValue()) {
                return false;
            }

            list($key, $iv) = $this->getAesKeyIv();
            $token = openssl_decrypt($cookie->getValue(), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            if (!$token) {
                return false;
            }

            $object = json_decode($token);
            if (!is_object($object) || !isset($object->id)) {
                return false;
            }
            container('session')->set(self::TOKEN_IN_SESSION_NAME, $object);
        }

        return true;
    }

    /**
     * Return true when username and password corrected, false otherwise
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $username, string $password): bool {
        if (password_verify($password, $this->author->getAuthorPassword())) {
            if ($this->author->getAuthorUsername() === $username) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate the token to persistent current session
     */
    public function signLoginToken(): void {
        $token = json_encode(['id' => $this->author->getAuthorId(), 'create_at' => current_date()]);

        list($key, $iv) = $this->getAesKeyIv();
        /* @var $cookies Cookies */
        $cookies = container('cookies');
        $value = base64_encode_safe(openssl_encrypt($token, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
        $cookies->set(self::TOKEN_IN_COOKIE_NAME, $value, 0, '/', false, null, true);
        container('session')->set(self::TOKEN_IN_SESSION_NAME, json_decode($token));
        $cookies->send();
    }

    /**
     * Save the information for current login
     *
     * @return bool
     * @throws ModelSaveException
     */
    protected function saveLoginInfo(): bool {
        /* @var Request $request */
        $request = container('request');

        $this->author->setLastLoginIp($request->getClientAddress(true));
        $this->author->setLastLoginTime(current_date());
        return $this->author->save();
    }

    /**
     * Returns a pair with <key, iv> for aes
     *
     * @return array
     */
    private function getAesKeyIv(): array {
        return array_map('base64_decode', [
            container('field')->get('security.aes.key', function() {
                return base64_encode(container('security')->getRandom()->bytes(32));
            }),
            container('field')->get('security.aes.iv', function() {
                return base64_encode(container('security')->getRandom()->bytes(16));
            }),
        ]);
    }

    /**
     * @const TOKEN_IN_SESSION_NAME The name of the token in the session
     */
    private const TOKEN_IN_SESSION_NAME = '$Here$Administrator$';

    /**
     * @const TOKEN_IN_COOKIE_NAME The name of the token in the cookie
     */
    private const TOKEN_IN_COOKIE_NAME = 'hh';

}
