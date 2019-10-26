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
namespace Here\Library\Mvc\Component;

use Phalcon\Di\Injectable;


/**
 * Trait Token
 * @package Here\Library\Mvc\Component
 * @mixin Injectable
 */
trait Token {

    /**
     * Name of the csrf token in the header
     *
     * @var string
     */
    protected $csrf_header_name = 'X-Csrf-Token';

    /**
     * Issued new csrf token into header in the response
     */
    final protected function issueTokenIntoHeader() {
        $this->response->setHeader('Access-Control-Allow-Headers', $this->csrf_header_name);
        $this->response->setHeader($this->csrf_header_name, container('csrf')->issueToken());
    }

    /**
     * Verify that the token from request header is valid
     *
     * @param bool $once
     * @return bool
     */
    final protected function verifyTokenFromHeader(bool $once): bool {
        if (!$this->request->hasHeader($this->csrf_header_name)) {
            return false;
        }
        return container('csrf')->verifyToken($this->request->getHeader($this->csrf_header_name), $once);
    }

}
