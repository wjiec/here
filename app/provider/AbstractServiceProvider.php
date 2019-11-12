<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider;

use LogicException;
use Phalcon\DiInterface;
use Phalcon\Mvc\User\Component;


/**
 * Class AbstractServiceProvider
 * @package Here\providers
 */
abstract class AbstractServiceProvider extends Component implements ServiceProviderInterface {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name;

    /**
     * AbstractServiceProvider constructor.
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di) {
        if (!$this->service_name) {
            throw new LogicException(sprintf('The service provider "%s" cannot have an empty name',
                get_class($this)));
        }
        $this->setDI($di);
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function getName(): string {
        return $this->service_name;
    }

    /**
     * @inheritDoc
     */
    public function register() {}

    /**
     * @inheritDoc
     */
    public function initialize() {}

}
