<?php
/**
 * Here interceptor
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget_Interceptor extends Here_Abstracts_Widget {
    /**
     * The routing table is not initialized at this time
     * 
     * Automatically intercepts the exception request
     * and sets a flag the correct resource request
     * 
     * @param array $options
     */
    public function __construct(array $options) {
        parent::__construct($options);

        $this->_xss_reject();
        $this->smart_router();
    }

    public function smart_router() {
        $current_url = Core::router_instance()->current_url();

        if (preg_match('/\/static\/([\w\d-_]+)\/(.*)\.([\w\d-_]+)/', $current_url, $matches)) {
            try {
                $suffix = $matches[3];
                $file_path = join('.', array($matches[2], $suffix));
                $real_file_path = join(_here_path_separator_, array('var', $matches[1], $file_path));

                Here_Request::mime($suffix);

                // return resource-file contents
                if (is_file($real_file_path)) {
                    include $real_file_path;
                    exit;
                }
            } catch (Exception $e) {
               Core::router_instance()->error('404', 'Not Found');
            }
        }
    }

    public function black_router() {
        
    }

    public function white_router() {
        
    }

    private function _xss_reject() {
        if (!empty($_GET) || !empty($_POST)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                exit;
            }

            $parts = parse_url($_SERVER['HTTP_REFERER']);
            if (!empty($parts['port'])) {
                $parts['host'] = "{$parts['host']}:{$parts['port']}";
            }

            if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
                exit;
            }
        }
    }
}
