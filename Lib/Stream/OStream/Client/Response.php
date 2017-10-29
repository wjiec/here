<?php
/**
 * Response.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Lib\Stream\OStream\Client\Component\ResponseHeader;
use Here\Lib\Stream\OStream\Client\Component\ResponseStatusCode;


/**
 * Class Response
 * @package Here\Lib\Stream\OStream\Client
 */
class Response {
    /**
     * modify response headers
     */
    use ResponseHeader;

    /**
     * modify response status code
     */
    use ResponseStatusCode;
}
