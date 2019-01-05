<?php
/**
 * RequestMask
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Signature\Component;


/**
 * Class RequestMask
 * @package Here\Libraries\Signature\Component
 */
final class RequestMask {

    /**
     * @var int
     */
    private $mask_value;

    /**
     * RequestMask constructor.
     * @param int|null $mask_value
     */
    final public function __construct(?int $mask_value = null) {
        $this->mask_value = $mask_value ?? self::randomMaskValue();
    }

    /**
     * @return int
     */
    final public function getValue(): int {
        return $this->mask_value;
    }

    /**
     * @return int
     */
    final private function randomMaskValue(): int {
        try {
            return random_int(self::MASK_VALUE_MIN, self::MASK_VALUE_MAX);
        } catch (\Exception $e) {
            return mt_rand(self::MASK_VALUE_MIN, self::MASK_VALUE_MAX);
        }
    }

    /**
     * min value of mask
     */
    private const MASK_VALUE_MIN = 0x1000;

    /**
     * max value of mask
     */
    private const MASK_VALUE_MAX = 0xffff;

}
