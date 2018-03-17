<?php
/**
 * IpNetwork.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Network;


/**
 * Class IpNetwork
 * @package Here\Lib\Utils\Network
 */
final class IPNetwork {
    /**
     * @var array
     */
    private $_ip_list = array();

    /**
     * IPNetwork constructor.
     * @param array $ip_addresses
     * @throws IPNetworkError
     */
    public function __construct(array $ip_addresses = array()) {
        // add to forbidden list
        foreach ($ip_addresses as $ip_address) {
            // the multi ip address
            if (strpos($ip_address, ',')) {
                $ip_address = explode(',', $ip_address);
            } else {
                $ip_address = array($ip_address);
            }

            foreach ($ip_address as $ip) {
                $ip = trim($ip);

                // CIDR ip address: xxx.xxx.xxx.xxx/xx
                if (strpos($ip, '/') === false) {
                    // single ip address
                    $this->add_ip($ip, 0);
                } else if (strpos($ip, '/') === strrpos($ip, '/')) {
                    list($address, $length) = explode('/', $ip, 2);
                    // push new ip address
                    $this->add_ip($address, $length);
                } else {
                    throw new IPNetworkError("CIDR address(`$ip`) format error");
                }
            }
        }
    }

    /**
     * Determines whether the specified address is not in the list
     *
     * @param string $ip_address
     * @return bool
     * @throws IPNetworkError
     */
    public function contains(string $ip_address): bool {
        // ip list is empty
        if (empty($this->_ip_list)) {
            return false;
        }

        // convert to number
        $number = self::ip_address_to_hex($ip_address);

        // check exists
        if (isset($this->_ip_list[$number])) {
            return true;
        }

        $bin_number = base_convert($number, 16, 2);
        foreach ($this->_ip_list as $ip => $length) {
            if ($length === 0) {
                continue;
            }

            $bin_ip = base_convert($number, 16, 2);
            $trimmed_bin_number = substr($bin_number, 0, strlen($bin_number) - $length);

            if (substr($bin_ip, 0, strlen($bin_ip) - $length) === $trimmed_bin_number) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $ip
     * @param int $length
     * @throws IPNetworkError
     */
    public function add_ip(string $ip, int $length = 0) {
        // presentation to number
        $number = self::ip_address_to_hex($ip);
        // check length
        if ($length < 0 || $length > 32) {
            throw new IPNetworkError('CIDR length invalid');
        }

        // if ip exists in list than update expired.
        $this->_ip_list[$number] = $length;
    }

    /**
     * @param string $ip_address
     * @return bool|string
     * @throws IPNetworkError
     */
    private static function ip_address_to_hex(string $ip_address) {
        // check is ipv6
        $is_ipv6 = false;

        // check is ipv4
        $is_ipv4 = false;

        // Filters a variable with FILTER_FLAG_IPV6
        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $is_ipv6 = true;
        }

        // Filters a variable with FILTER_FLAG_IPV4
        else if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $is_ipv4 = true;
        }

        // invalid ip address
        if (!$is_ipv4 && !$is_ipv6) {
            throw new IPNetworkError("ip address(`{$ip_address}`) invalid");
        }

        // IPv4 format
        if ($is_ipv4) {
            $parts = explode('.', $ip_address);
            foreach ($parts as &$part) {
                $part = str_pad(dechex($part), 2, '0', STR_PAD_LEFT);
            }

            $ip_address = '::' . $parts[0] . $parts[1] . ':' . $parts[2] . $parts[3];
            // build hex string
            $hex_result = join('', $parts);
        } else {
            // IPv6 format
            $parts = explode(':', $ip_address);

            // If this is mixed IPv6/IPv4, convert end to IPv6 value
            if (filter_var($parts[count($parts) - 1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
                // ::127.0.0.1
                $v4_parts = explode('.', $parts[count($parts) - 1]);
                // the same to IPv4
                foreach ($v4_parts as &$v4_part) {
                    $v4_part = str_pad(dechex($v4_part), 2, '0', STR_PAD_LEFT);
                }

                // position: last - 1
                $parts[count($parts) - 1] = $v4_parts[0] . $v4_parts[1];
                // position: last, 7
                $parts[] = $v4_parts[2] . $v4_parts[3];
            }

            // miss part count
            $num_missing = 8 - count($parts);
            // using 0000 replace
            $expanded_parts = array();
            // result parts
            $expansion_done = false;
            // all parts of the known
            foreach ($parts as $part) {
                if (!$expansion_done && $part == '') {
                    for($i = 0; $i <= $num_missing; $i++) {
                        $expanded_parts[] = '0000';
                    }
                    $expansion_done = true;
                } else {
                    $expanded_parts[] = $part;
                }
            }

            // pad string
            foreach ($expanded_parts as &$part) {
                $part = str_pad($part, 4, '0', STR_PAD_LEFT);
            }

            $ip_address = join(':', $expanded_parts);
            $hex_result = join('', $expanded_parts);
        }

        // validate the final IP
        if (!filter_var($ip_address, FILTER_VALIDATE_IP)) {
            return false;
        }

        // build
        return strtolower(str_pad($hex_result, 32, '0', STR_PAD_LEFT));
    }
}
