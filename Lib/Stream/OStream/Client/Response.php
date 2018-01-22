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
use Here\Lib\Utils\Interfaces\InitializerInterface;
use Here\Lib\Stream\OStream\Client\Component\ResponseHeader;
use Here\Lib\Stream\OStream\Client\Component\ResponseOperation;


/**
 * Class Response
 * @package Here\Lib\Stream\OStream\Client
 */
class Response implements InitializerInterface {
    /**
     * modify response headers
     */
    use ResponseHeader;

    /**
     * operation of response
     */
    use ResponseOperation;
}
