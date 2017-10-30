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
use Here\Lib\Exceptions\Level\ExceptionLevelTrait;


/**
 * Class ExceptionBase
 * @package Here\Lib\Abstracts
 */
abstract class ExceptionBase extends \Exception {
    /**
     * exception Level trait
     */
    use ExceptionLevelTrait;

    /**
     * default error code
     */
    private const DEFAULT_ERROR_CODE = 1996;

    /**
     * @var string
     */
    protected $_message;

    /**
     * @var StackTrace
     */
    protected $_stack_trace;

    /**
     * ExceptionBase constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message, Throwable $previous = null) {
        // exception message
        $this->_message = $message;
        $this->_stack_trace = new StackTrace();

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
     * @return string
     */
    final public function __toString(): string {
        $called_class_name = get_called_class();
        $trace_string = "{$called_class_name}(\"{$this->_message}\")\n";

        foreach ($this->_stack_trace as $stack) {
            $trace_string .= sprintf("#%d [ %s:%s ] <===> %s%s%s(%s);\n", ...array(
                $stack[StackTrace::STACK_TRACE_CALLED_INDEX],
                $stack[StackTrace::STACK_TRACE_CALLED_AT],
                $stack[StackTrace::STACK_TRACE_CALLED_LINE],
                $stack[StackTrace::STACK_TRACE_CLASS_NAME],
                $stack[StackTrace::STACK_TRACE_CALL_OPERATOR],
                $stack[StackTrace::STACK_TRACE_FUNCTION_NAME],
                $stack[StackTrace::STACK_TRACE_ARGUMENTS]
                /**
                 * @TODO stringify arguments
                 */
            ));
        }
        return $trace_string;
    }
}
