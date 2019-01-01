<?php
/**
 * accessible routing definitions
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Here\Plugins\AppRouter;
use Phalcon\Di;


/* dependency management */
$di = Di::getDefault();

$di->setShared('router', function() {
    /* create an router and using custom route table */
    return (new AppRouter())
        // frontend initializing required
        ->viaGet('/init', 'frontend', 'init')
        // create new blogger
        ->viaPut('/author', 'author', 'create')
    ;
});
