<?php
/**
 * EnvironmentController.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Controllers;


/**
 * Class EnvironmentController
 * @package Here\Controllers
 */
final class FrontendController extends ControllerBase {

    /**
     * initializing frontend environment
     * @throws \Exception
     */
    final public function initAction() {
        return $this->makeResponse(self::STATUS_OK, null, array(
            'secret' => array(
                'rsa' => 'public rsa key',
                'random' => random_int(1000, 9999)
            )
        ), array(
            'redirect' => '/installer/first'
        ));
    }

}
