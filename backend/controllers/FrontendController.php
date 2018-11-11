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


use Here\Libraries\RSA\RSAGenerator;
use Here\Models\Wrapper\Author;


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
        $force = $this->request->getQuery('force', 'trim', 'false');

        return $this->makeResponse(self::STATUS_SUCCESS, null, array(
            'security' => array(
                'rsa' => RSAGenerator::generate()->get(),
                'mask' => random_int(1000, 9999)
            ),
            'author' => Author::generate()->get($force === 'true'),
            'lang' => $this->translator->getLang()
        ));
    }

}
