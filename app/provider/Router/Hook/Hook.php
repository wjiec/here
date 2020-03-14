<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Router\Hook;

use Phalcon\Mvc\Router;


/**
 * Class Hook
 * @package Here\Provider\Router\Hook
 */
class Hook {

    /**
     * Hooks the router on notFound or something else
     *
     * @param Router $router
     */
    public static function hook(Router $router) {
        $router->notFound(['module' => 'tinder', 'controller' => 'error', 'action' => 'notFound']);
    }

}
