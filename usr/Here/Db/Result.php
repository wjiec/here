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
     * result pointer to an arbitrary row in the result
     *
     * @var int
     */
    private $_current_row = 0;

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
     * result
     * 
     * @var array
     */
    private $_result = null;

    /**
     * Result Class constructor
     *
     * @param array $result
     * @param int $affected_rows
     */
    public function __construct(array $result, $affected_rows) {
        $this->_current_row = 0;
        $this->_affected_rows = is_int($affected_rows) ? $affected_rows : -1;
        $this->_rows_count = count($result);
        $this->_result = $result;
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
     */
    public function fetch() {
        $keys = func_get_args();

        // fetch all fields
        if (empty($key)) {
            return $this->_result[$this->_current_row++];
        }

        // fetch some field
        $result = array();
        foreach ($keys as $key) {
            $result[$key] = isset($this->_result[$this->_current_row][$key]) ? $this->_result[$this->_current_row][$key] : null;

            $this->_current_row += 1;
        }
        return $result;
    }

    /**
     * Adjusts the result pointer to an arbitrary row in the result
     *
     * @param int $offset
     */
    public function seek($offset) {
        $this->_current_row = ($offset >= 0 && $offset <= $this->_rows_count) ? $offset : $this->_current_row;
    }

    /**
     * Reset the result pointer
     */
    public function reset() {
        $this->_current_row = 0;
    }

    /**
     * affected row count
     *
     * @return int
     */
    public function affected_row() {
        return $this->_affected_rows;
    }
}
