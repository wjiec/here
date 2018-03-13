<?php
/**
 * RequestMethods.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream\Client;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class RequestMethods
 * @package Here\Lib\Stream\IStream\Client
 */
final class RequestMethods extends EnumType {
    /**
     * get method
     */
    public const GET = 'get';

    /**
     * post method
     */
    public const HEAD = 'head';

    /**
     * post method
     */
    public const POST = 'post';

    /**
     * put method
     */
    public const PUT = 'put';

    /**
     * delete method
     */
    public const DELETE = 'delete';

    /**
     * connect method
     */
    public const CONNECT = 'connect';

    /**
     * options method
     */
    public const OPTIONS = 'options';

    /**
     * trace method
     */
    public const TRACE = 'trace';

    /**
     * patch method
     */
    public const PATCH = 'patch';

    /**
     * @return array
     */
    public static function get_browser_compatibility_methods(): array {
        # https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
        return array(
            self::CONNECT, self::DELETE, self::GET, self::HEAD, self::OPTIONS, self::POST, self::PUT
        );
    }
}
