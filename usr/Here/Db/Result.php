<?php
/**
 * Here Db Query Result Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Db_Result {
    /**
     * result data internal pointer
     *
     * @var int
     */
    protected $_result_current_index = 0;

    /**
     * total of rows
     *
     * @var int
     */
    private $_rows_count = 0;

    /**
     * total of affected rows
     *
     * @var int
     */
    private $_affected_rows = 0;

    /**
     * query result
     * 
     * @var array
     */
    private $_result = null;

    /**
     * query string, using for debug/check error
     *
     * @var string
     */
    private $_query_string;

    /**
     * Result Class constructor
     *
     * @param array $result
     * @param int $affected_rows
     * @param int $last_insert_id
     * @param string $query_string
     */
    public function __construct(array $result, $affected_rows, $last_insert_id, $query_string) {
        $this->_affected_rows = is_int($affected_rows) ? $affected_rows : -1;
        $this->_rows_count = count($result);
        $this->_result = $result;
        $this->_query_string = $query_string;
    }

    /**
     * Fetches all result rows as an associative array
     *
     * @return array
     */
    public function fetch_all() {
        return $this->_result;
    }

    /**
     * Get a result row as an associative array
     *
     * @return array
     * @throws Here_Exceptions_OutOfRange
     */
    public function get_values(/* ... */) {
        $keys = func_get_args();

        if ($this->_result_current_index >= $this->_rows_count) {
            throw new Here_Exceptions_OutOfRange("internal index is out of range, please reset index",
                'Here:Db:Result:get_values');
        }

        // fetch all fields
        if (empty($keys)) {
            return $this->_result[$this->_result_current_index++];
        }

        // fetch some field
        $result = array();
        foreach ($keys as $key) {
            $result[$key] = isset($this->_result[$this->_result_current_index][$key]) ? $this->_result[$this->_result_current_index][$key] : null;

            $this->_result_current_index += 1;
        }
        return $result;
    }

    /**
     * sets the position indicator associated with the rows to a new position.
     *
     * @param int $index
     * @throws Here_Exceptions_OutOfRange
     */
    final public function seek($index) {
        if ($this->_result && is_array($this->_result) && count($this->_result) > $index && $index > 0) {
            $this->_result_current_index = $index;
        } else {
            throw new Here_Exceptions_OutOfRange('index out of range', 'Here:Db:Result:seek');
        }
    }

    /**
     * reposition rows position indicator
     */
    final public function reset() {
        $this->_result_current_index = 0;
    }

    /**
     * affected row count
     *
     * @return int
     */
    public function affected_row() {
        return $this->_affected_rows;
    }

    /**
     * getting current result query string
     *
     * @return string
     */
    public function query_string() {
        return $this->query_string();
    }
}
