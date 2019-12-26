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
use Phalcon\Http\Request;
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

}
