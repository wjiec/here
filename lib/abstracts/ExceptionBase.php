<?php
/**
 * ExceptionBaseBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Abstracts;
use Throwable;
use Here\Lib\Assert;
use Here\Lib\Exception\Level\Error;


/**
 * Class ExceptionBase
 * @package Here\Lib\Abstracts
 */
abstract class ExceptionBase extends \Exception {
    /**
     * error code
     *
     * @var string
     */
    protected $_code;

    /**
     * error message
     *
     * @var string
     */
    protected $_message;

    /**
     * @var ExceptionLevelBase
     */
    protected $_level;

    /**
     * ExceptionBase constructor.
     * @param string $message
     * @param ExceptionLevelBase $level
     * @param Throwable|null $previous
     */
    public function __construct($message, ExceptionLevelBase $level = null, Throwable $previous = null) {
        // exception message
        Assert::String($message);
        $this->_message = $message;

        // exception level
        if ($level === null) {
            $level = new Error();
        }
        $this->_level = $level;

        // resolve exception code
        $this->_resolve_exception_code();

        // make sure using get_message override method
        parent::__construct('Please using ExceptionBase::get_message method',
            self::DEFAULT_ERROR_CODE, $previous);
    }

    /**
     * @return string
     */
    final public function get_code() {
        return $this->_code;
    }

    /**
     * @return string
     */
    final public function get_message() {
        return $this->_message;
    }

    /**
     * resolve exception code
     */
    final private function _resolve_exception_code() {
    }

    /**
     * default error code
     */
    const DEFAULT_ERROR_CODE = 1996;
}
