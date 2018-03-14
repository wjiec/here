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
        LastException::set_exception($this);

        // make sure using get_message override method
        parent::__construct('Please using ExceptionBase::get_message method',
            $this->get_level(), $previous);
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
            $trace_string .= sprintf("#%d [ %s:%s ] <----> %s%s%s(%s);\n", ...array(
                $stack[StackTrace::STACK_TRACE_CALLED_INDEX],
                $stack[StackTrace::STACK_TRACE_CALLED_AT],
                $stack[StackTrace::STACK_TRACE_CALLED_LINE],
                $stack[StackTrace::STACK_TRACE_CLASS_NAME],
                $stack[StackTrace::STACK_TRACE_CALL_OPERATOR],
                $stack[StackTrace::STACK_TRACE_FUNCTION_NAME],
                self::_stringify_arguments(...$stack[StackTrace::STACK_TRACE_ARGUMENTS])
                /**
                 * @TODO stringify arguments
                 */
            ));
        }
        return $trace_string;
    }

    /**
     * @param $arguments
     * @return string
     */
    final private static function _stringify_arguments(...$arguments): string {
        $result = array();

        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $result[] = 'array(' . join(',', array_map(function($v) {
                    return self::_stringify_arguments($v);
                }, $argument)) . ')';
            } else if (is_string($argument)) {
                $result[] = "'{$argument}'";
            } else if (is_integer($argument) || is_float($argument)) {
                $result[] = strval($argument);
            } else if (is_object($argument)) {
                $result[] = get_class($argument);
            } else if (is_null($argument)) {
                $result[] = 'null';
            } else {
                $result[] = 'UNKNOWN';
            }
        }

        return join(',', $result);
    }
}
