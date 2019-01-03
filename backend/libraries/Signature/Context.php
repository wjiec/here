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
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\DiInterface;


/**
 * Class Context
 * @package Here\Libraries\Signature
 */
final class Context extends Injectable {

    /**
     * @var int
     */
    private $request_mask;

    /**
     * Context constructor.
     * @param null|DiInterface $di
     */
    final public function __construct(?DiInterface $di = null) {
        $this->setDI($di ?? Di::getDefault());

        // initializing signature context
        if (!$this->session->has(SessionKeys::SESSION_KEY_REQUEST_MASK)) {
            $this->session->set(SessionKeys::SESSION_KEY_REQUEST_MASK, self::initRequestMask());
        }
        $this->request_mask = $this->session->get(SessionKeys::SESSION_KEY_REQUEST_MASK);
    }

    /**
     * first 8-bits signature
     * @return int
     */
    final private static function initRequestMask(): int {
        try {
            return random_int(0x1111, 0xffff);
        } catch (\Exception $e) {
            return mt_rand(0x1111, 0xffff);
        }
    }

}
