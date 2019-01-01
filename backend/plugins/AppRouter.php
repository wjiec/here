<?php
/**
 * AppRouteTable
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Plugins;


use Phalcon\Mvc\Router;


/**
 * Class AppRouteTable
 * @package Here\Plugins
 */
final class AppRouter extends Router {

    /**
     * AppRouteTable constructor.
     * @param bool $defaultRoutes
     */
    final public function __construct(bool $defaultRoutes = false) {
        parent::__construct($defaultRoutes);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $action
     * @return AppRouter
     */
    final public function viaGet(string $pattern, string $controller, string $action): self {
        $this->addGet($pattern, array('controller' => $controller, 'action' => $action));
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $action
     * @return AppRouter
     */
    final public function viaPost(string $pattern, string $controller, string $action): self {
        $this->addPost($pattern, array('controller' => $controller, 'action' => $action));
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $action
     * @return AppRouter
     */
    final public function viaUpdate(string $pattern, string $controller, string $action): self {
        $this->add($pattern, array('controller' => $controller, 'action' => $action))->via('UPDATE');
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $action
     * @return AppRouter
     */
    final public function viaPut(string $pattern, string $controller, string $action): self {
        $this->addPut($pattern, array('controller' => $controller, 'action' => $action));
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $action
     * @return AppRouter
     */
    final public function viaDelete(string $pattern, string $controller, string $action): self {
        $this->addDelete($pattern, array('controller' => $controller, 'action' => $action));
        return $this;
    }

}
