<?php
/**
 * services definition in here
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;
use Phalcon\Di;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;


/* default dependency management */
$di = Di::getDefault();

/* shared configuration service */
$di->setShared('config', function () {
    return include APPLICATION_ROOT . "/config/config.php";
});

/* the URL component is used to generate all kind of urls in the application */
$di->setShared('url', function () use ($di) {
    $url = new UrlResolver();
    $url->setBaseUri($di->get('config')->application->base_uri);

    return $url;
});

/* setting up the view component */
$di->setShared('view', function () use ($di) {
    $config = $di->get('config');

    $view = new View();
    $view->setDI($di);
    $view->setViewsDir($config->application->views_root);

    $view->registerEngines(array(
        '.volt' => function ($view) use ($config) {
            $volt = new VoltEngine($view, $this);

//            $volt->setOptions(array(
//                'compiledPath' => $config->application->cache_root,
//                'compiledSeparator' => '_'
//            ));

            return $volt;
        },
        '.phtml' => PhpEngine::class
    ));

    return $view;
});

/* database connection is created based in the parameters defined in the configuration file */
$di->setShared('db', function () use ($di) {
    $config = $di->get('config');

    // find database provider
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = array(
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    );

    // PostgreSQL not need charset
    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});


/* if the configuration specify the use of metadata adapter use it or use memory otherwise */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/* register the session flash service with the Twitter Bootstrap classes */
$di->set('flash', function () {
    return new Flash(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
