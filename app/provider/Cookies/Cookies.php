<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
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
