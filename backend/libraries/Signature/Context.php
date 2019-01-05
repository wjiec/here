<?php
/**
 * Signature Context
 *
 * Format: xxxx-xxxxxx-xxxxxx-xxxxxx
 *         ^^^^ 1
 *              ^^^^^^ 2
 *                     ^^^^^^ 3
 *                            ^^^^^^ 4
 * 1. mask with request timeline
 * 2. md5 value for request body
 * 3.
 * 4.
 *
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Signature;


use Here\Libraries\Session\SessionKeys;
use Here\Libraries\Signature\Component\RequestMask;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\DiInterface;
use Phalcon\Session\AdapterInterface;


/**
 * Class Context
 * @package Here\Libraries\Signature
 */
final class Context extends Injectable {

    /**
     * @var RequestMask
     */
    private $request_mask;

    /**
     * Context constructor.
     * @param null|DiInterface $di
     */
    final private function __construct(?DiInterface $di = null) {
        $this->setDI($di ?? Di::getDefault());
    }

    /**
     * @return Context
     * @throws SignatureException
     */
    final public static function factoryFromSession(): self {
        /* @var AdapterInterface $session */
        $session = Di::getDefault()->getShared('session');

        if (!$session->has(SessionKeys::SESSION_KEY_REQUEST_MASK)) {
            throw new SignatureException("Invalid signature context");
        }
        return new static();
    }

    /**
     * @return Context
     */
    final public static function createContext(): self {
        $context = new static();
        return $context->setRequestMask(new RequestMask());
    }

    /**
     * @return int
     */
    final public function getRequestMaskAsInt(): int {
        return $this->request_mask->getValue();
    }

    /**
     * @param RequestMask $mask
     * @return Context
     */
    final private function setRequestMask(RequestMask $mask): self {
        $this->request_mask = $mask;
        $this->session->set(SessionKeys::SESSION_KEY_REQUEST_MASK, $mask);

        return $this;
    }

}
