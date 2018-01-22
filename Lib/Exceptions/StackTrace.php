<?php
/**
 * StackTrace.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions;


/**
 * Class StackTrace
 * @package Here\Lib\Exceptions
 */
class StackTrace implements \IteratorAggregate {
    /**
     * @var array
     */
    private $_trace_back;

    /**
     * StackTrace constructor.
     */
    final public function __construct() {
        self::_analysis_stack_trace(debug_backtrace());
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->_trace_back);
    }

    /**
     * @param array $stack_trace
     */
    final private function _analysis_stack_trace(array $stack_trace): void {
        foreach ($stack_trace as $index => $call_info) {
            $this->_trace_back[] = array(
                self::STACK_TRACE_CALLED_INDEX  => $index,
                self::STACK_TRACE_CALLED_AT     => $call_info['file'],
                self::STACK_TRACE_CALLED_LINE   => $call_info['line'],
                self::STACK_TRACE_CLASS_NAME    => $call_info['class'] ?? '',
                self::STACK_TRACE_FUNCTION_NAME => $call_info['function'],
                self::STACK_TRACE_CALL_OPERATOR => $call_info['type'] ?? '::',
                self::STACK_TRACE_ARGUMENTS     => $call_info['args']
            );
        }
    }

    /**
     * called item index
     */
    public const STACK_TRACE_CALLED_INDEX = 'top';

    /**
     * called at where
     */
    public const STACK_TRACE_CALLED_AT = 'called_at';

    /**
     * called at line number
     */
    public const STACK_TRACE_CALLED_LINE = 'called_line';

    /**
     * class name
     */
    public const STACK_TRACE_CLASS_NAME = 'class_name';

    /**
     * function name
     */
    public const STACK_TRACE_FUNCTION_NAME = 'function_name';

    /**
     * call operator
     */
    public const STACK_TRACE_CALL_OPERATOR = 'call_operator';

    /**
     * call arguments
     */
    public const STACK_TRACE_ARGUMENTS = 'arguments';
}
