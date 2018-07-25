<?php
/**
 * services definition in here
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Exception;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Mvc\Dispatcher\Exception as DispatcherException;


/* default dependency management */
$di = Di::getDefault();

/* shared configuration service */
$di->setShared('config', function() {
    /* @var Config $config */
    $config = include APPLICATION_ROOT . '/configs/config.php';

    // check configure for develop exists
    if (is_readable(APPLICATION_ROOT . '/configs/config.dev.php')) {
        $override_config = include APPLICATION_ROOT . '/configs/config.dev.php';
        $config->merge($override_config);
    }

    return $config;
});

/* configure service for application */
$config = $di->get('config');

/* the URL component is used to generate all kind of urls in the application */
$di->setShared('url', function() use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->base_uri);

    return $url;
});

/* setting up the view component */
$di->setShared('view', function() use ($di, $config) {
    /* view component */
    $view = new View();
    $view->setDI($di);
    $view->setViewsDir($config->application->views_root);

    /* volt template engine */
    $view->registerEngines(array(
        '.volt' => function($view) use ($config) {
            $volt = new VoltEngine($view, $this);

            $caches_root = '/tmp/';
            if (isset($config->application->caches_root)) {
                $config_caches_root = rtrim($config->application->caches_root) . '/';
                if (is_writable($config_caches_root)) {
                    $caches_root = $config_caches_root;
                }
            }

            $volt->setOptions(array(
                'compiledPath' =>  $caches_root,
                'compiledSeparator' => '_'
            ));

            return $volt;
        }
    ));

    return $view;
});

/* database connection is created based in the parameters defined in the configuration file */
if (isset($config->database)) {
    $di->setShared('db', function() use ($di, $config) {
        // find database provider
        $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
        $params = array(
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname,
            'charset' => $config->database->charset
        );

        // PostgreSQL not need charset
        if ($config->database->adapter == 'Postgresql') {
            unset($params['charset']);
        }

        return new $class($params);
    });
}

/* cache service with redis */
if (isset($config->cache)) {
    $di->setShared('cache', function() use ($config, $di) {
        $frontend_config = $config->cache->frontend->toArray();
        $frontend_adapter = $frontend_config['adapter'];
        unset($frontend_config['adapter']);

        $frontend_class = 'Phalcon\Cache\Frontend\\' . $frontend_adapter;
        $frontend = new $frontend_class($frontend_config);

        $backend_config = $config->cache->backend->toArray();
        $backend_adapter = $backend_config['adapter'];
        unset($backend_config['adapter']);

        $backend_class = 'Phalcon\Cache\Backend\\' . $backend_adapter;
        return new $backend_class($frontend, $backend_config);
    });
}

/* @todo logging service */
//$di->setShared('logging', function() use ($config) {
//
//});

/* default dispatcher service */
$di->setShared('dispatcher', function() {
    $events_manager = new EventsManager();

    // exceptions forward
    $events_manager->attach('dispatch:beforeException',
        function(Event $event, Dispatcher $dispatcher, Exception $exception) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                case Dispatcher::EXCEPTION_INVALID_HANDLER:
                    $dispatcher->forward(array(
                        'module' => 'frontend',
                        'controller' => 'error',
                        'action' => 'notFound',
                        'params' => array(
                            'message' => $exception->getMessage()
                        )
                    ));
                    return false;
            }
            return true;
        }
    );

    // modules forward
    $events_manager->attach('dispatch:beforeForward',
        function(Event $event, Dispatcher $dispatcher, array $forward) {
            /* @var Config $config */
            $config = $dispatcher->getDI()->get('config');

            if (isset($forward['module']) && isset($config->modules)) {
                // check whether the module is registered
                if (!isset($config->modules->{$forward['module']})){
                    throw new DispatcherException(sprintf('Module %s does not exists', $forward['module']));
                }

                // check whether module contains meta data
                $module_data = $config->modules->{$forward['module']};
                if (!isset($module_data['metadata']) || !isset($module_data['metadata']['controllers_namespace'])) {
                    // @todo think of something nice to automatically get controller dir from existing config?
                    throw new DispatcherException(sprintf('Module %s does not have meta data. ' .
                        'controllers_namespace must be specified', $forward['module']));
                }

                // set controller namespace
                $metadata = $module_data->metadata;
                $dispatcher->setNamespaceName($metadata->controllers_namespace);

                // set controller suffix
                if(isset($metadata->controllers_suffix) && !empty($metadata->controllers_suffix)) {
                    /* @var DispatcherInterface $dispatcher */
                    $dispatcher->setControllerSuffix($metadata->controllers_suffix);
                }

                // set action suffix
                if(isset($metadata->actions_suffix) && !empty($metadata->actions_suffix)){
                    $dispatcher->setActionSuffix($metadata->actions_suffix);
                }
            }
        }
    );

    // create new dispatcher
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($events_manager);
    $dispatcher->setDefaultNamespace('Here\Frontend\Controllers');

    return $dispatcher;
});

/* if the configuration specify the use of metadata adapter use it or use memory otherwise */
$di->setShared('modelsMetadata', function() {
    return new MetaDataAdapter();
});

/* start the session the first time some component request the session service */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
