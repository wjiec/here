<?php
/**
 * BackendModule.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Backend;


use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;


/**
 * Class BackendModule
 * @package Here\Backend
 */
final class BackendModule implements ModuleDefinitionInterface {
    /**
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
    }

    /**
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
        /* @var Config $config */
        $config = $di->get('config');

        // view service for frontend module
        $di->set('view', function() use ($di, $config) {
            /* create new view service for frontend */
            $view = new View();
            $view->setDI($di);

            /* set frontend views root */
            if (isset($config->frontend)) {
                $view->setViewsDir($config->frontend->views_root);
            }

            /* volt template engine */
            $view->registerEngines(array(
                '.volt' => function($view) use ($config) {
                    $volt = new VoltEngine($view, $this);

                    // options for volt template engine
                    $volt->setOptions(array(
                        'compiledPath' => function(string $template_path) use ($config) : string {
                            // remove `views/`
                            $relative_path = substr($template_path, strpos($template_path, 'views') + 6);
                            list($module, $relative_path) = explode('/', $relative_path, 2);

                            if (is_writeable($config->application->compiled_templates_root)) {
                                $caches_root = $config->application->compiled_templates_root . '/' . $module;
                            } else {
                                $caches_root = '/tmp/' . $module;
                            }
                            $file_name = str_replace(array('/', '.'), '_', $relative_path);

                            $cache_file_path = $caches_root . '/' . $file_name . '.php';
                            $cache_dir_path = dirname($cache_file_path);
                            if (!is_dir($cache_dir_path)) {
                                mkdir($cache_dir_path, 0777, true);
                            }

                            return $cache_file_path;
                        }
                    ));

                    return $volt;
                }
            ));

            return $view;
        });
    }
}
