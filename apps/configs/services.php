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
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;


/* default dependency management */
$di = Di::getDefault();

/* shared configuration service */
$di->setShared('config', function() {
    return include APPLICATION_ROOT . "/configs/config.php";
});

/* the URL component is used to generate all kind of urls in the application */
$di->setShared('url', function() use ($di) {
    $url = new UrlResolver();
    $url->setBaseUri($di->get('config')->application->base_uri);

    return $url;
});

/* setting up the view component */
$di->setShared('view', function() use ($di) {
    $config = $di->get('config');

    /* view component */
    $view = new View();
    $view->setDI($di);
    $view->setViewsDir($config->application->views_root);

    /* volt template engine */
    $view->registerEngines(array(
        '.volt' => function($view) {
            return new VoltEngine($view, $this);
        }
    ));

    return $view;
});

/* database connection is created based in the parameters defined in the configuration file */
$di->setShared('db', function() use ($di) {
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
$di->setShared('modelsMetadata', function() {
    return new MetaDataAdapter();
});

/* start the session the first time some component request the session service */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
