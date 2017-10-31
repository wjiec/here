<?php
/**
 * HttpStatusCode.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Http;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class HttpStatusCode
 * @package Here\Lib\Stream\OStream\Client
 */
final class HttpStatusCode extends EnumType {
    /**
     * default http status code
     */
    const __default = self::HTTP_STATUS_OK;

    /**
     * http status code: 100 -> continue;
     */
    public const HTTP_STATUS_CONTINUE = 100;

    /**
     * http status code: 101 -> switching protocols
     */
    public const HTTP_STATUS_SWITCHING = 101;

    /**
     * http status code: 200 -> ok [default]
     */
    public const HTTP_STATUS_OK = 200;

    /**
     * http status code: 201 -> created
     */
    public const HTTP_STATUS_CREATED = 201;

    /**
     * http status code: 202 -> accepted
     */
    public const HTTP_STATUS_ACCEPTED = 202;

    /**
     * http status code: 203 -> non-authoritative information
     */
    public const HTTP_STATUS_NON_AUTH_INFO = 203;

    /**
     * http status code: 204 -> no content
     */
    public const HTTP_STATUS_NO_CONTENT = 204;

    /**
     * http status code: 205 -> reset content
     */
    public const HTTP_STATUS_RESET_CONTENT = 205;

    /**
     * http status code: 206 -> partial content
     */
    public const HTTP_STATUS_PARTIAL_CONTENT = 206;

    /**
     * http status code: 300 -> multiple choice
     */
    public const HTTP_STATUS_MULTIPLE_CHOICES = 300;

    /**
     * http status code: 301 -> moved permanently
     */
    public const HTTP_STATUS_MOVED_PERMANENTLY = 301;

    /**
     * http status code: 302 -> moved temporarily
     */
    public const HTTP_STATUS_TEMPORARILY = 302;

    /**
     * http status code: 303 -> see other
     */
    public const HTTP_STATUS_SEE_OTHER = 303;

    /**
     * http status code: 304 -> not modified
     */
    public const HTTP_STATUS_NOT_MODIFIED = 304;

    /**
     * http status code: 305 -> use proxy
     */
    public const HTTP_STATUS_USE_PROXY = 305;

    /**
     * http status code: 400 -> bas request
     */
    public const HTTP_STATUS_BAD_REQUEST = 400;

    /**
     * http status code: 401 -> unauthorized
     */
    public const HTTP_STATUS_UNAUTHORIZED = 401;

    /**
     * http status code: 402 -> payment required
     */
    public const HTTP_STATUS_PAYMENT_REQUIRED = 402;

    /**
     * http status code: 403 -> forbidden
     */
    public const HTTP_STATUS_FORBIDDEN = 403;

    /**
     * http status code: 404 -> not found
     */
    public const HTTP_STATUS_NOT_FOUND = 404;

    /**
     * http status code: 405 -> method not allowed
     */
    public const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;

    /**
     * http status code: 406 -> not acceptable
     */
    public const HTTP_STATUS_NOT_ACCEPTABLE = 406;

    /**
     * http status code: 407 -> proxy authentication required
     */
    public const HTTP_STATUS_PROXY_AUTH_REQUIRED = 407;

    /**
     * http status code: 408 -> request timeout
     */
    public const HTTP_STATUS_REQUEST_TIMEOUT = 408;

    /**
     * http status code: 409 -> conflict
     */
    public const HTTP_STATUS_CONFLICT = 409;

    /**
     * http status code: 410 -> gone
     */
    public const HTTP_STATUS_GONE = 410;

    /**
     * http status code: 411 -> length required
     */
    public const HTTP_STATUS_LENGTH_REQUIRED = 411;

    /**
     * http status code: 412 -> precondition failed
     */
    public const HTTP_STATUS_PRECONDITION_FAILED = 412;

    /**
     * http status code: 413 -> request entity too large
     */
    public const HTTP_STATUS_REQUEST_ENTITY_TOO_LARGE = 413;

    /**
     * http status code: 414 -> request-uri too large
     */
    public const HTTP_STATUS_REQUEST_URI_TOO_LARGE = 414;

    /**
     * http status code: 415 -> unsupported media type
     */
    public const HTTP_STATUS_UNSUPPORTED_MEDIA_TYPE = 414;

    /**
     * http status code: 500 -> internal server error
     */
    public const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    /**
     * http status code: 501 -> not implemented
     */
    public const HTTP_STATUS_NOT_IMPLEMENTED = 501;

    /**
     * http status code: 502 -> bad gateway
     */
    public const HTTP_STATUS_BAD_GATEWAY = 502;

    /**
     * http status code: 503 -> service unavailable
     */
    public const HTTP_STATUS_SERVICE_UNAVAILABLE = 503;

    /**
     * http status code: 504 -> gateway timeout
     */
    public const HTTP_STATUS_GATEWAY_TIMEOUT = 504;

    /**
     * http status code: 505 -> http version not supported
     */
    public const HTTP_STATUS_HTTP_VERSION_NOT_SUPPORTED = 505;
}















































$_GET;