<?php
/**
 * InstallerController.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Frontend\Controllers;


use Here\Controllers\ControllerBase;


/**
 * Class InstallerController
 * @package Here\Frontend\Controllers
 */
final class InstallerController extends ControllerBase {

    /**
     * first step of application
     */
    final public function firstAction() {
        return $this->view;
    }

}
