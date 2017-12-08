<?php
/**
 * Stack.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Stack;


/**
 * Class Stack
 * @package Here\Lib\Ext\Stack
 */
class Stack {
    /**
     * @var array
     */
    private $_stack;

    /**
     * @var int
     */
    private $_index;

    /**
     * Stack constructor.
     */
    final public function __construct() {
        $this->_index = -1;
        $this->_stack = array();
    }

    /**
     * @param $element
     * @return int
     */
    final public function push($element): int {
        $this->_stack[++$this->_index] = $element;
        return $this->_index;
    }

    /**
     * @return mixed
     * @throws EmptyStackError
     */
    final public function pop() {
        if ($this->_index === -1) {
            throw new EmptyStackError("empty stack");
        }
        return $this->_stack[$this->_index--];
    }

    /**
     * @return mixed
     * @throws EmptyStackError
     */
    final public function top() {
        if ($this->_index === -1) {
            throw new EmptyStackError("empty stack");
        }
        return $this->_stack[$this->_index];
    }

    /**
     * @param int $offset
     * @return mixed
     * @throws StackGlimpseIndexError|EmptyStackError
     */
    final public function glimpse(int $offset = 0) {
        if ($offset > $this->_index || $offset < 0) {
            throw new StackGlimpseIndexError("glimpse index invalid");
        } else if ($this->_index === -1) {
            throw new EmptyStackError("empty stack");
        }

        return $this->_stack[$this->_index - $offset];
    }

    /**
     * @param $element
     * @return bool
     */
    final public function has_element($element): bool {
        return array_search($element, $this->_stack);
    }
}
