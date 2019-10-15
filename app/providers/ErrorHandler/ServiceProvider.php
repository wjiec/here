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
namespace Here\Providers\ErrorHandler;

use Here\Libraries\Exception\Handler\ErrorPageHandler;
use Here\Libraries\Exception\Handler\LoggerHandler;
use Here\Providers\AbstractServiceProvider;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


/**
 * Class ServiceProvider
 * @package Here\Providers\ErrorHandler
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'errorHandler';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared("{$this->service_name}.loggerHandler", LoggerHandler::class);
        $this->di->setShared("{$this->service_name}.prettyPageHandler", PrettyPageHandler::class);
        $this->di->setShared("{$this->service_name}.errorPageHandler", ErrorPageHandler::class);

        $service_name = $this->service_name;
        $this->di->setShared($this->service_name, function() use ($service_name) {
            $run = new Run();
            $run->appendHandler(container("{$service_name}.loggerHandler"));

            if (env('BLOG_DEBUG', false)) {
                $run->appendHandler(container("{$service_name}.prettyPageHandler"));
            } else {
                $run->appendHandler(container("{$service_name}.errorPageHandler"));
            }
            return $run;
        });
    }

    /**
     * @inheritDoc
     */
    final public function initialize() {
        /* @var $run Run */
        $run = container($this->service_name);
        $run->register();
    }

}
