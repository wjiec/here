<?php
/**
 * FrontendController
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers;


use Here\Controllers\Base\AuthorControllerBase;
use Here\Libraries\RSA\RSAObject;
use Here\Libraries\Signature\Context;


/**
 * Class FrontendController
 * @package Here\Controllers
 */
final class FrontendController extends AuthorControllerBase {

    /**
     * initializing frontend environment
     * @throws \Exception
     */
    final public function initAction() {
        /* @var RSAObject $rsa_object */
        $rsa_object = $this->di->getShared('rsa');
        $author = $this->getCachedAuthor();

        $signature_context = Context::createContext();
        return $this->makeResponse(self::STATUS_SUCCESS, null, array(
            'security' => array(
                'key' => $rsa_object->getPublicKey(true),
                'mask' => $signature_context->getRequestMaskAsInt()
            ),
            'author' => $author ? $author->getBaseInfo() : null,
            'lang' => $this->t->getLang()
        ));
    }

}
