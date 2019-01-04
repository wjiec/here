<?php
/**
 * services definition in here
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Here\Libraries\Hunter\ErrorCatcher;
use Here\Libraries\Redis\RedisKeys;
use Here\Libraries\RSA\RSAObject;
use Here\Libraries\Session\CookieKeys;
use Here\Plugins\AppEventsManager;
use Here\Plugins\AppLoggerProvider;
use Here\Plugins\AppRedisBackend;
use Here\Plugins\AppRequest;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;


/* default dependency management */
$di = Di::getDefault();

/* shared configuration service */
$di->setShared('config', function() {
    /* @var Config $config */
    $config = include APPLICATION_ROOT . '/configs/config.php';

    // check configure for develop exists
    if (is_readable(APPLICATION_ROOT . '/configs/config.dev.php')) {
        /** @noinspection PhpIncludeInspection */
        $override_config = include APPLICATION_ROOT . '/configs/config.dev.php';
        if ($override_config instanceof Config) {
            $config->merge($override_config);
        }
    }

    // check configure file for environment exists
    $environment_file = sprintf('%s/configs/env/%s.php', APPLICATION_ROOT, APPLICATION_ENV);
    if (is_file($environment_file) && is_readable($environment_file)) {
        /** @noinspection PhpIncludeInspection */
        $environment_config = include $environment_file;
        if ($environment_config instanceof Config) {
            $config->merge($environment_config);
        }
    }

    return $config;
});

/* configure service for application */
$config = $di->getShared('config');

/* database connection is created based in the parameters defined in the configuration file */
if (isset($config->database)) {
    $di->setShared('db', function() use ($di, $config) {
        /* find database provider */
        $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
        $params = $config->database->toArray();

        /* PostgreSQL not need charset */
        if ($config->database->adapter === 'Postgresql') {
            unset($params['charset']);
        }

        return new $class($params);
    });
} else {
    // invalid environment configure for database
    $di->setShared('db', function() {
        throw new \Exception("environment invalid, please check environment configure");
    });
}

/* cache service with redis */
if (isset($config->cache)) {
    $di->setShared('cache', function() use ($config, $di) {
        /* frontend configure */
        $frontend_config = $config->cache->frontend->toArray();
        $frontend_adapter = $frontend_config['adapter'];
        unset($frontend_config['adapter']);
        /* create frontend instance */
        $frontend_class = 'Phalcon\Cache\Frontend\\' . $frontend_adapter;
        $frontend = new $frontend_class($frontend_config);

        /* backend configure */
        $backend_config = $config->cache->backend->toArray();
        $backend_adapter = $backend_config['adapter'];
        unset($backend_config['adapter']);
        /* backend default configure */
        $backend_config['persistent'] = $backend_config['persistent'] ?? false;

        /* replace RedisBackend with AppRedisBackend */
        if ($backend_adapter === 'Redis') {
            $backend_class = AppRedisBackend::class;
        } else {
            $backend_class = 'Phalcon\Cache\Backend\\' . $backend_adapter;
        }
        return new $backend_class($frontend, $backend_config);
    });
} else {
    // invalid environment configure for cache service
    $di->setShared('cache', function() {
        throw new \Exception("environment invalid, please check environment configure");
    });
}

/* logging service */
$di->setShared('logging', function() use ($config) {
    return (new AppLoggerProvider())->getDefaultLogger();
});

/* default dispatcher service */
$di->setShared('dispatcher', function() use ($config) {
    $events_manager = new AppEventsManager();

    // create new dispatcher
    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($events_manager);
    $dispatcher->setDefaultNamespace($config->application->controllers_namespace);

    // register error listener when application running on server mode
    if (APPLICATION_MODE === SERVER_APPLICATION) {
        ErrorCatcher::registerListener(function(string $error) use ($dispatcher) {
            // forward to internal-error
            $dispatcher->forward(array(
                'controller' => 'error',
                'action' => 'internal',
                'params' => array(
                    'error' => $error
                )
            ));
            // dispatch again and make error message to client
            $dispatcher->dispatch();
        });
    }

    return $dispatcher;
});

/* if the configuration specify the use of metadata adapter use it or use memory otherwise */
$di->setShared('modelsMetadata', function() {
    return new MetaDataAdapter();
});

/* cookies service */
$di->set('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(true);

    return $cookies;
});


/* start the session the first time some component request the session service */
$di->setShared('session', function () {
    $session = new SessionAdapter();

    $session->setName(CookieKeys::COOKIE_KEY_SESSION_IDENTIFIER);
    $session->start();

    return $session;
});

/* default rsa crypt object */
$di->setShared('rsa', function() use ($di) {
    /* @var AppRedisBackend $cache */
    $cache = $di->getShared('cache');

    // from cache getting rsa object
    if (!$cache->exists(RedisKeys::getRSAPrivateRedisKey())) {
        // regenerate rsa object
        $cache->save(RedisKeys::getRSAPrivateRedisKey(), function() {
            return RSAObject::generate(1024);
        });
    }
    return $cache->get(RedisKeys::getRSAPrivateRedisKey());
});

/* override request service */
$di->setShared('request', function() use ($di) {
    $request = new AppRequest();
    $request->setRsaObject($di->getShared('rsa'));

    return $request;
});
