<?php
/**
 * FrontendController.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Controllers;


/**
 * Class FrontendController
 * @package Here\Controllers
 */
final class FrontendController extends SecurityControllerBase {

    /**
     * initializing frontend environment
     * @throws \Exception
     */
    final public function initAction() {
        $rsa_object = $this->getCachedRSAObject();
        $author = $this->getCachedAuthor();

        return $this->makeResponse(self::STATUS_SUCCESS, null, array(
            'security' => array(
                'key' => $rsa_object->getPublicKey(true),
                'mask' => random_int(self::SECURITY_MASK_RANGE_START, self::SECURITY_MASK_RANGE_END)
            ),
            'author' => $author ? $author->toArray() : null,
            'lang' => $this->translator->getLang()
        ));
    }

    private const SECURITY_MASK_RANGE_START = 100000;

    private const SECURITY_MASK_RANGE_END = 999999;

}
