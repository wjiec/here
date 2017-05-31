<?php
/**
 * Here widget:IPNetwork
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class Here_Widget_IPNetwork
 *
 * IPNetwork widget
 */
class Here_Widget_IPNetwork extends Here_Abstracts_Widget {
    /**
     * @var array
     * @access private
     */
    private $_forbidden_list = array();

    /**
     * Here_Widget_IPNetwork constructor.
     *
     * @param array $options
     * @throws Here_Exceptions_WidgetError
     */
    public function __construct(array $options = array()) {
        // 父类初始化
        parent::__construct($options);
        // set current widget name
        $this->set_widget_name('IP Network');
        // add to forbidden list
        foreach ($options as $ip_address => $expired) {
            // the multi ip address
            if (strpos($ip_address, ',')) {
                $ip_address = explode(',', $ip_address);
            } else {
                $ip_address = array($ip_address);
            }
            // foreach all ip
            foreach ($ip_address as $ip) {
                $ip = trim($ip);
                // CIDR ip address: xxx.xxx.xxx.xxx/xx
                if (strpos($ip, '/') === false) {
                    // single ip address
                    $this->forbidden_push($ip, 0, $expired);
                } else if (strpos($ip, '/') === strrpos($ip, '/')) {
                    list($address, $length) = explode('/', $ip, 2);
                    // push new ip address
                    $this->forbidden_push($address, $length, $expired);
                } else {
                    throw new Here_Exceptions_WidgetError("CIDR address(`$ip`) format error",
                        'Here:Widget:IpNetwork:__construct');
                }
            }
        }
    }

    /**
     * Determines whether the specified address is not in the list
     *
     * @param string $ip_address
     * @return bool
     */
    public function contains($ip_address) {
        // forbidden list is empty
        if (empty($this->_forbidden_list)) {
            return false;
        }
        // convert to number
        $number = self::_ip_to_hex($ip_address);
        // check exists
        return array_key_exists($number, $this->_forbidden_list);
    }

    /**
     * push new ip address to forbidden list
     *
     * @param string $ip
     * @param int $length
     * @param int $expired
     * @throws Here_Exceptions_WidgetError
     */
    public function forbidden_push($ip, $length = 0, $expired = _here_forbidden_default_expired_) {
        // presentation to number
        $number = self::_ip_to_hex($ip);
        // check length
        if ($length < 0 || $length > 32) {
            throw new Here_Exceptions_WidgetError("CIDR length invalid",
                'Here:Widget:IpNetwork:_add_new_ip');
        }
        // if ip exists in list than update expired.
        $this->_forbidden_list[$number] = $expired;
    }

    /**
     * @param string $ip_address
     * @return string
     * @throws Here_Exceptions_WidgetError
     */
    private static function _ip_to_hex($ip_address) {
        // check is ipv6
        $is_ipv6 = false;
        // check is ipv4
        $is_ipv4 = false;
        // Filters a variable with FILTER_FLAG_IPV6
        if(filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $is_ipv6 = true;
        }
        // Filters a variable with FILTER_FLAG_IPV4
        else if(filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $is_ipv4 = true;
        }
        // invalid ip address
        if(!$is_ipv4 && !$is_ipv6) {
            throw new Here_Exceptions_WidgetError("ip address(`{$ip_address}`) invalid",
                'Here:Widget:IpNetwork:_ip_to_hex');
        }
        // IPv4 format
        if($is_ipv4) {
            $parts = explode('.', $ip_address);
            for($i = 0; $i < 4; $i++) {
                // 1 => 001
                $parts[$i] = str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
            }
            $ip_address = '::' . $parts[0] . $parts[1] . ':' . $parts[2] . $parts[3];
            // build hex string
            $hex_result = join('', $parts);
        } else {
            // IPv6 format
            $parts = explode(':', $ip_address);
            // If this is mixed IPv6/IPv4, convert end to IPv6 value
            if(filter_var($parts[count($parts) - 1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
                // ::127.0.0.1
                $v4_parts = explode('.', $parts[count($parts) - 1]);
                // the same to IPv4
                for($i = 0; $i < 4; $i++) {
                    $v4_parts[$i] = str_pad(dechex($v4_parts[$i]), 2, '0', STR_PAD_LEFT);
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
            foreach($parts as $part) {
                if(!$expansion_done && $part == '') {
                    for($i = 0; $i <= $num_missing; $i++) {
                        $expanded_parts[] = '0000';
                    }
                    $expansion_done = true;
                }
                else {
                    $expanded_parts[] = $part;
                }
            }
            // pad string
            foreach($expanded_parts as &$part) {
                $part = str_pad($part, 4, '0', STR_PAD_LEFT);
            }
            $ip_address = join(':', $expanded_parts);
            $hex_result = join('', $expanded_parts);
        }
        // validate the final IP
        if(!filter_var($ip_address, FILTER_VALIDATE_IP)) {
            return false;
        }
        // build
        return strtolower(str_pad($hex_result, 32, '0', STR_PAD_LEFT));
    }
}
