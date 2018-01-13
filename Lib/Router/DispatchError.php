<?php
/**
 * DispatchError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;
use Throwable;


/**
 * Class DispatchError
 * @package Here\Lib\Router\Collector
 */
class DispatchError extends ExceptionBase {
    /**
     * error level
     */
    use Error;

    /**
     * @var int
     */
    private $_error_code;

    /**
     * DispatchError constructor.
     * @param int $code
     * @param string $message
     * @param null|Throwable $previous
     */
    final public function __construct(int $code, string $message, ?Throwable $previous = null) {
        parent::__construct($message, $previous);

        $this->_error_code = $code;
    }

    /**
     * @return int
     */
    final public function get_error_code(): int {
        return $this->_error_code;
    }
}
