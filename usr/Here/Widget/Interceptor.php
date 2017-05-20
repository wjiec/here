<?php
/**
 * Here interceptor
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget_Interceptor extends Here_Abstracts_Widget {
    /**
     * The routing table is not initialized at this time
     * 
     * Automatically intercepts the exception request
     * 
     * @param array $options
     */
    public function __construct(array $options) {
        parent::__construct($options);
        $this->set_widget_name('Interceptor');

        $this->_reject_robots();
        $this->_ip_policy_init();
    }

    /**
     * reject robot request
     */
    private function _reject_robots() {
        if (!empty($_GET) || !empty($_POST)) {
            if (empty(Here_Request::get_env('http_referer'))) {
                Here_Request::abort(403, 'are you human?');
            }

            $parts = parse_url(Here_Request::get_env('http_referer'));
            if (!empty($parts['port'])) {
                $parts['host'] = "{$parts['host']}:{$parts['port']}";
            }

            if (empty($parts['host']) || Here_Request::get_env('http_host') != $parts['host']) {
                Here_Request::abort(403, "you're are not human");
            }
        }
    }

    /**
     * initializing ip policy
     */
    private function _ip_policy_init() {
        // include forbidden list
        $forbidden_list = include(_here_sys_default_ip_policy_);
        if (!is_array($forbidden_list)) {
            throw new Exception('Default Forbidden IP is not array.', 1996);
        }
        /* @var Here_Widget_IPNetwork $ip_network */
        $ip_network = Here_Widget::widget('IPNetwork', null, $forbidden_list);
        // check current client not in forbidden list
        if ($ip_network->contains(Here_Request::get_remote_ip())) {
            Here_Request::abort(403, "you've been blacklisted");
        }
    }

    /**
     * get Widget:IPNetwork instance
     *
     * @return Here_Widget_Interceptor
     */
    public static function get_ip_network() {
        return Here_Widget::widget('IPNetwork');
    }
}
