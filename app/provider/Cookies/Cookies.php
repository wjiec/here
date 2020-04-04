<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Cookies;

use Phalcon\Http\Response\Cookies as HttpCookies;


/**
 * Class Cookies
 * @package Here\Provider\Cookies
 */
class Cookies extends HttpCookies {

    /**
     * Adds a httpOnly cookie
     *
     * @param string $name
     * @param string $value
     * @param string|null $path
     * @param string|null $domain
     * @return HttpCookies
     */
    public function add(string $name, string $value, ?string $path = null, ?string $domain = null) {
        return $this->set($name, $value, 0, $path, false, $domain, true);
    }

}
