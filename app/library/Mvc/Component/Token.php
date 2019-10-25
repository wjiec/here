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
use Phalcon\Security\Exception;
use Phalcon\Security\Random;


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
     * Name of the key of the token in the session
     *
     * @var string
     */
    protected $csrf_token_key = '$Here/Security/Csrf$';

    /**
     * Number of the tokens allowed overflow saved
     *
     * @var int
     */
    protected $csrf_overflow_count = 4;

    /**
     * Issued new csrf token into session and return
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     *
     * @return string
     * @throws Exception
     */
    final protected function issueToken(): string {
        $tokens = $this->session->get($this->csrf_token_key, array());
        if (count($tokens) > $this->csrf_overflow_count) {
            array_shift($tokens);
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $tokens[] = (new Random())->uuid();
        $this->session->set($this->csrf_token_key, $tokens);
        return end($tokens);
    }

    /**
     * @throws Exception
     */
    final protected function issueTokenIntoHeader() {
        $this->response->setHeader('Access-Control-Allow-Headers', $this->csrf_header_name);
        $this->response->setHeader($this->csrf_header_name, $this->issueToken());
    }

    /**
     * Verify that the token is valid
     *
     * @param string $token
     * @param bool $once
     * @return bool
     */
    final protected function verifyToken(string $token, bool $once = true): bool {
        $valid_token_index = -1;
        $valid_tokens = $this->session->get($this->csrf_token_key, array());
        foreach ($valid_tokens as $index => $valid_token) {
            if ($token === $valid_token) {
                $valid_token_index = $index;
            }
        }

        unset($valid_tokens[$valid_token_index]);
        if ($valid_token_index !== -1 && $once) {
            for ($index = 0; $index < $valid_token_index; $index++) {
                unset($valid_tokens[$index]);
            }
        }

        $this->session->set($this->csrf_token_key, array_values($valid_tokens));
        return $valid_token_index !== -1;
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
        return $this->verifyToken($this->request->getHeader($this->csrf_header_name), $once);
    }

}
