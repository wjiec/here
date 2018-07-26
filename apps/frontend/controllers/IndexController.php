<?php
/**
 * IndexController.php
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
 * Class IndexController
 * @package Here\Frontend\Controllers
 */
final class IndexController extends ControllerBase {

    /**
     * index/home page action
     */
    final public function indexAction() {
        $this->dispatcher->forward(array(
            'module' => 'frontend',
            'controller' => 'installer',
            'action' => 'first'
        ));
    }

}
