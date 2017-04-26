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
                Here_Request::abort(403, 'your not human.');
            }
        }
    }

    /**
     * initializing ip policy
     */
    private function _ip_policy_init() {

    }
}
