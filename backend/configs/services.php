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
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Logger\Adapter\File as FileLogger;


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

/* database connection is created based in the parameters defined in the configuration file */
if (isset($config->database)) {
    $di->setShared('db', function() use ($di, $config) {
        /* find database provider */
        $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
        $params = array(
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname,
            'charset' => $config->database->charset
        );

        /* PostgreSQL not need charset */
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

/* logging service */
$di->setShared('logging', function() use ($config) {
    $logger_file = $config->application->logging_root . '/' . $config->logging->name;
    if (!is_dir(dirname($logger_file)) || !is_writable(dirname($logger_file))) {
        $logger_file = '/tmp/' . $config->logging->name;
    }

    return new FileLogger($logger_file);
});

/* default dispatcher service */
$di->setShared('dispatcher', function() use ($config) {
    $events_manager = new EventsManager();

    // exceptions forward
    $events_manager->attach('dispatch:beforeException',
        function(Event $event, Dispatcher $dispatcher, Exception $exception) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                case Dispatcher::EXCEPTION_INVALID_HANDLER:
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action' => 'notFound',
                        'params' => array(
                            'context' => $event,
                            'message' => $exception->getMessage()
                        )
                    ));
                    return false;
            }
            return true;
        }
    );

    // create new dispatcher
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($events_manager);
    $dispatcher->setDefaultNamespace($config->application->controllers_namespace);

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
