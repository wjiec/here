<?php
/**
 * Here Cache Manager, Cookies/Session/CacheServer/KVServer
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_CacheManager
 */
class Here_CacheManager {
    /**
     * cookies key value pairs
     *
     * @var array
     */
    private static $_cookies;

    /**
     * server cookies
     *
     * @var array
     */
    private static $_sessions;

    /**
     * default cookie path
     *
     * @var string
     */
    private static $_cookie_path = '/';

    /**
     * default cookie domain
     *
     * @var null|string
     */
    private static $_cookie_domain = null;

    /**
     * Here_CacheManager constructor.
     */
    public function __construct() {

    }

    /**
     * set cookie to client
     *
     * @param string $key
     * @param string|mixed $value
     * @param int $expire
     * @param string|null $path
     * @param null $domain
     * @param bool $http_only
     * @throws Here_Exceptions_ParameterError
     */
    public static function set_cookie($key, $value, $expire = 0, $path = null, $domain = null, $http_only = true) {
        // parse cookie path
        if ($path === null) {
            $path = self::$_cookie_path;
        }
        // parse cookie domain
        if ($domain === null) {
            $domain = self::$_cookie_domain;
        }
        // check key-value type
        Here_Utils::check_type('key', $key, 'string',
            'Here:CacheManager:set_cookie');
        // check value is string ot string-like(has __toString method)
        if (!is_string($value)) {
            if (method_exists($value, '__toString')) {
                $value = call_user_func(array($value, '__toString'));
            } else {
                // create `serialize` Class
                $value = new stdClass();
                // push to class
                $value->serialize = $value;
                // serialize `serialize` Class
                $value = serialize($value);
            }
        }
        // check expire time
        if (!is_int($expire)) {
            $expire = 0;
        } else {
            // expire time is unix timestamp
            $expire += time();
        }
        // setting
        self::$_cookies[$key] = $value;
        // sync to $_COOKIE
        setcookie($key, $value, $expire, $path, $domain, Here_Request::is_secure(), $http_only);
    }

    /**
     * from cookies getting item
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function get_cookie($key, $default = null) {
        if (array_key_exists($key, self::$_cookies)) {
            return self::$_cookies[$key];
        }
        return $default;
    }

    /**
     * set item to session
     *
     * @param string $key
     * @param mixed $value
     * @throws Here_Exceptions_ParameterError
     */
    public static function set_session($key, $value) {
        // start session
        self::_start_session();
        // check key parameter type
        Here_Utils::check_type('key', $key, 'string',
            'Here:CacheManager:set_session');
        // storage session key-value pair
        self::$_sessions[$key] = $value;
        // sync to $_SESSION
        $_SESSION[$key] = $value;
    }

    /**
     * from session getting item
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get_session($key, $default = null) {
        // start session
        self::_start_session();
        // check key exists
        if (array_key_exists($key, self::$_sessions)) {
            return self::$_sessions[$key];
        }
        // key non exists
        return $default;
    }

    /**
     * initializing cookies and sessions
     */
    public static function init_cache_manager() {
        // init cookies
        self::$_cookies = $_COOKIE;
        // init sessions
        self::$_sessions = $_SESSION ?: array();
    }

    /**
     * set default cookie path
     *
     * @param string $path
     */
    public static function set_default_cookie_path($path) {
        Here_Utils::check_type('path', $path, 'string',
            'Here:CacheManager:set_default_cookie_path');
        self::$_cookie_path = $path;
    }

    /**
     * set default cookie domain
     *
     * @param string $domain
     */
    public static function set_default_cookie_domain($domain) {
        Here_Utils::check_type('domain', $domain, 'string',
            'Here:CacheManager:set_default_cookie_path');
        self::$_cookie_domain = $domain;
    }

    /**
     * start session on session is closed
     */
    private static function _start_session() {
        // check session is started
        if (!session_id()) {
            // start session
            session_start();
            // sync to private member
            self::$_sessions = $_SESSION;
        }
    }
}
