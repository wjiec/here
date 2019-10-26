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
namespace Here\Provider\Csrf;


use Phalcon\Security\Exception;
use Phalcon\Security\Random;
use Phalcon\Session\AdapterInterface as SessionInterface;

/**
 * Class Token
 * @package Here\Provider\Csrf
 */
final class Token {

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
     * @var SessionInterface
     */
    protected $session;

    /**
     * Token constructor.
     */
    final public function __construct() {
        $this->session = container('session');
    }

    /**
     * Issued new csrf token into session and return
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     *
     * @return string
     * @throws Exception
     */
    final public function issueToken(): string {
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
     * Verify that the token is valid
     *
     * @param string $token
     * @param bool $once
     * @return bool
     */
    final public function verifyToken(string $token, bool $once = true): bool {
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

}
