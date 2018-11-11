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


/**
 * Class BloggerController
 * @package Here\controllers
 */
final class BloggerController extends SecurityControllerBase {

    /**
     * initializing blogger account and blog info
     * @throws \Here\Libraries\RSA\RSAError
     */
    final public function createAction() {
        // author created and terminal request
        if ($this->getCachedAuthor() !== null) {
            $this->terminal(403);
        }

        $raw_params = $this->request->getRawBody();
        // using rsa-object decrypt user-data
        $rsa_object = $this->getCachedRSAObject();
        // decrypt by private key
        $string_params = $rsa_object->decrypt($raw_params);
    }

}
