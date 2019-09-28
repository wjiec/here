<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Providers\Volt;

use Here\Providers\AbstractServiceProvider;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;


/**
 * Class ServiceProvider
 * @package Here\Providers\Volt
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'volt';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(ViewBaseInterface $view, DiInterface $di = null) {
            $volt = new Volt($view, $di ?? container());

            $volt->setOptions(array(
                'path' => function(string $path): string {
                    $relative_path = trim(mb_substr($path, mb_strlen(dirname(app_path()))), '\\/');
                    $basename = basename(str_replace(array('\\', '/'), '_', $relative_path), '.volt');

                    $cache_dir = cache_path('volt');
                    if (!is_dir($cache_dir)) {
                        @mkdir($cache_dir, 0755, true);
                    }

                    return $cache_dir . DIRECTORY_SEPARATOR . $basename . '.php';
                },
                'always' => env('development') || env('BLOG_DEBUG', false),
                /* @deprecated  */
                'compileAlways' => env('development') || env('BLOG_DEBUG', false),
                'compiledPath' => function(string $path): string {
                    $relative_path = trim(mb_substr($path, mb_strlen(dirname(app_path()))), '\\/');
                    $basename = basename(str_replace(array('\\', '/'), '_', $relative_path), '.volt');

                    $cache_dir = cache_path('volt');
                    if (!is_dir($cache_dir)) {
                        @mkdir($cache_dir, 0755, true);
                    }

                    return $cache_dir . DIRECTORY_SEPARATOR . $basename . '.php';
                },
            ));
            $volt->getCompiler()->addExtension(new Functions());

            return $volt;
        });
    }

}
