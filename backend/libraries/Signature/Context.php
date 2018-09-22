<?php
/**
 * Context.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 */
namespace Here\Libraries\Signature;


use Here\Libraries\RSA\RSAObject;


/**
 * Class Context
 * @package Here\Libraries\Signature
 */
final class Context {

    /**
     * @var int
     */
    private $timestamp_mask;

    /**
     * @var RSAObject
     */
    private $private_key;

    /**
     * Context constructor.
     * @param RSAObject $rsa
     */
    final public function __construct(RSAObject $rsa) {
        $this->private_key = $rsa;
        $this->timestamp_mask = self::generateTimestampMask();
    }

    /**
     * @param int $mask
     */
    final public function setTimestampMask(int $mask) {
        $this->timestamp_mask = $mask;
    }

    /**
     * @return int
     */
    private static function generateTimestampMask(): int {
        try {
            return random_int(self::TIMESTAMP_MASK_START, self::TIMESTAMP_MASK_END);
        } catch (\Exception $e) {
            return (self::TIMESTAMP_MASK_START + self::TIMESTAMP_MASK_END) / 2;
        }
    }

    private const TIMESTAMP_MASK_START = 100000000;

    private const TIMESTAMP_MASK_END = 999999998;

}
