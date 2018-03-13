<?php
/**
 * IpValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class IpValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class IpValidator extends IoFilterBase {
    /**
     * IpValidator constructor.
     * @param int $family
     * @param bool $private_range
     * @param bool $reserved_range
     */
    public function __construct(
        $family = self::IP_VALIDATOR_FAMILY_ALL,
        $private_range = true,
        $reserved_range = true
    ) {
        $this->add_flag($family);

        if ($private_range === false) {
            $this->add_flag(FILTER_FLAG_NO_PRIV_RANGE);
        }
        if ($reserved_range === false) {
            $this->add_flag(FILTER_FLAG_NO_RES_RANGE);
        }
    }

    /**
     * @see IoFilterInterface::apply()
     * @param string $object
     * @param mixed|null $default
     * @return string|mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_IP, $this->get_options());
    }

    // IPv4 family
    const IP_VALIDATOR_FAMILY_V4 = FILTER_FLAG_IPV4;

    // IPv6 family
    const IP_VALIDATOR_FAMILY_V6 = FILTER_FLAG_IPV6;

    // Ipv4 & IPv6
    const IP_VALIDATOR_FAMILY_ALL = self::IP_VALIDATOR_FAMILY_V4 | self::IP_VALIDATOR_FAMILY_V6;
}
