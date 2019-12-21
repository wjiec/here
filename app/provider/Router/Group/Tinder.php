<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Router\Group;

use Phalcon\Mvc\Router\Group as RouteGroup;


/**
 * Class Tinder
 * @package Here\Provider\Router\Group
 */
final class Tinder extends RouteGroup {

    /**
     * Route group of tinder module for frontend pages,
     * It has more pages, included
     *  - homepage
     *  - article(with comments)
     *  - and so on
     */
    final public function initialize() {
        $this->setPaths(['module' => 'tinder']);
        $this->setPrefix('/');

        $this->addExplore();
        $this->addFeed();
    }

    /**
     * Homepage shows the author info and article
     * list to viewer
     */
    final public function addExplore() {
        $this->addGet('', ['controller' => 'explore'])
            ->setName('explore');
    }

    /**
     * RSS/feed subscribe
     */
    final public function addFeed() {
        $this->addGet('feed', ['controller' => 'feed'])
            ->setName('feed');
    }

}
