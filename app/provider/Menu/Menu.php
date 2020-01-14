<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Menu;

use Phalcon\Config;
use Phalcon\Mvc\Router\Route;
use function Here\Library\Xet\array_at;


/**
 * Class Menu
 * @package Here\Provider\Menu
 */
class Menu {

    /**
     * The menu configure and structures
     *
     * @var array
     */
    protected $menu;

    /**
     * @var string
     */
    protected $route;

    /**
     * Menu constructor.
     * @param array $menu
     */
    public function __construct(array $menu) {
        $this->menu = $menu;
        /* @var $route Route */
        if ($route = container('router')->getMatchedRoute()) {
            $this->route = $route->getName();
        }
    }

    /**
     * Returns the menu configure
     *
     * @return Config
     */
    public function getConfig(): Config {
        return new Config(array_map(function(array $menu) {
            if (array_at($menu, 'name') === $this->route) {
                $menu['activated'] = true;
            } else if (!empty(array_at($menu, 'children'))) {
                foreach ($menu['children'] as $index => $child) {
                    if (array_at($child, 'name') === $this->route) {
                        $menu['opened'] = true;
                        $menu['children'][$index]['activated'] = true;
                        break;
                    }
                }
            }

            return $menu;
        }, $this->menu));
    }

}
