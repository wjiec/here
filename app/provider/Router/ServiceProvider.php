<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Router;

use Bops\Mvc\Router\Router;
use Bops\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Router\Group;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Router
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'router';
    }

    /**
     * Register the service
     *
     * @return void
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            $router = new Router();
            $router->clear();
            $router->removeExtraSlashes(true);

            $tinder = (new Group(['module' => 'tinder']))->setPrefix('/');
            $tinder->addGet('', ['controller' => 'explore'])->setName('explore');
            $tinder->addGet('/feed', ['controller' => 'feed'])->setName('feed');
            $tinder->addGet('/article/{name:.+}', ['controller' => 'article'])->setName('article');
            $tinder->addPut('/article/{id:\w+}/comment', ['controller' => 'article', 'action' => 'comment']);
            $tinder->addGet('/category/{name:.+}', ['controller' => 'category'])->setName('category');
            $tinder->add('search', ['controller' => 'search'])->setName('search');
            $router->mount($tinder);

            $adminPrefix = container('field')->get('blog.admin.prefix', 'admin');
            $admin = (new Group(['module' => 'admin']))->setPrefix('/' . ltrim($adminPrefix, '/'));
            $admin->addGet('/', ['controller' => 'dashboard'])->setName('dashboard');
            $admin->addGet('/dashboard', ['controller' => 'dashboard'])->setName('dashboard');
            $admin->addGet('/setup', ['controller' => 'setup'])->setName('setup-wizard');
            $admin->addPut('/setup/complete', ['controller' => 'setup', 'action' => 'complete'])
                ->setName('setup-complete');
            $router->mount($admin);

            return $router;
        });
    }

}
