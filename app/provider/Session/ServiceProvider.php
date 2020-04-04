<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Session;

use Bops\Provider\AbstractServiceProvider;
use Phalcon\Session\Adapter\Files;


/**
 * Class ServiceProvider
 * @package Here\Provider\Session
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'session';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            $session = new Files([
                'prefix' => 'here_session_',
                'uniqueId' => 'here_session_',
                'lifetime' => 1440
            ]);
            $session->setName('_hs');
            $session->start();

            return $session;
        });
    }

}
