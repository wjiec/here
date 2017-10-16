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
namespace Here\Lib\Exceptions;
use Throwable;
use Here\Lib\Assert;
use Here\Lib\Toolkit;
use Here\Lib\Exceptions\Level\ExceptionLevelBase;


/**
 * Class ExceptionBase
 * @package Here\Lib\Abstracts
 */
abstract class ExceptionBase extends \Exception {
    /**
     * exception level trait
     */
    use ExceptionLevelBase;

    /**
     * error message
     *
     * @var string
     */
    protected $_message;

    /**
     * @var array
     */
    protected $_backtrace;

    /**
     * ExceptionBase constructor.
     * @param string $message
     * @param ExceptionLevelBase $level
     * @param Throwable|null $previous
     */
    public function __construct(string $message, ExceptionLevelBase $level = null, Throwable $previous = null) {
        // exception message
        Assert::String($message);
        $this->_message = $message;

        // resolve exception code
        $this->_resolve_backtrace();

        // make sure using get_message override method
        parent::__construct('Please using ExceptionBase::get_message method',
            self::DEFAULT_ERROR_CODE, $previous);
    }

    /**
     * @return string
     */
    final public function get_message() {
        return $this->_message;
    }

    /**
     * @return array
     */
    final public function get_backtrace() {
        return $this->_backtrace;
    }

    /**
     * resolve exception code
     */
    final private function _resolve_backtrace() {
        $backtrace = Toolkit::get_backtrace();
        foreach ($backtrace as $item) {
            $this->_backtrace[] = array(
                'file' => $item['file'],
                'line' => $item['line'],
                'class' => $item['class'],
                'function' => $item['function'],
                'call_type' => $item['type']
            );
        }
    }

    /**
     * default error code
     */
    const DEFAULT_ERROR_CODE = 1996;
}
