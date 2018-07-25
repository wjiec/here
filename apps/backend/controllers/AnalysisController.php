<?php
/**
 * AnalysisController.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Backend\Controllers;


use Here\Controllers\ControllerBase;


/**
 * Class AnalysisController
 * @package Here\Backend\Controllers
 */
final class AnalysisController extends ControllerBase {

    /**
     * page viewer
     */
    final public function viewAction() {
        var_dump(bin2hex(random_bytes(32)));
    }

}
