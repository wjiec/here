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
namespace Here;


use Phalcon\Application;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;
use \Phalcon\Mvc\Application as MvcApplication;


/**
 * Class Bootstrap
 * @package Here
 */
final class Bootstrap {

    /**
     * @var Application
     */
    private $app;

    /**
     * @var DiInterface
     */
    private $di;


    /**
     * Bootstrap constructor.
     */
    final public function __construct() {
        $this->di = new FactoryDefault();
        $this->app = new MvcApplication($this->di);

        Di::setDefault($this->di);
    }

    /**
     * @return $this
     */
    final public function run(): self {
        return $this;
    }

    /**
     * @return void
     */
    final public function output() {
        echo $this->app->handle();
    }

}
