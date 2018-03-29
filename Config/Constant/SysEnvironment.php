<?php
/**
 * SysEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Constant;


/**
 * Class SysEnvironment
 * @package Here\Config\Constant
 */
final class SysEnvironment {
    /**
     * current status for response commit flag
     * @internal private
     */
    public const ENV_COMMIT_STATUS = '__response_commit_status__';

    /**
     * request method on cli mode
     */
    public const ENV_REQUEST_METHOD = '__cli_request_method__';

    /**
     * request uri on cli mode
     */
    public const ENV_REQUEST_URI = '__cli_request_uri__';
}
