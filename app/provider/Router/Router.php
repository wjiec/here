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
namespace Here\Provider\Router;

use Phalcon\Mvc\Router as MvcRouter;


/**
 * Class Router
 * @package Here\Provider\Router
 */
final class Router extends MvcRouter {

    /**
     * Router constructor.
     */
    final public function __construct() {
        parent::__construct(false);
    }

}
