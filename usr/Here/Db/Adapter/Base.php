<?php
/**
 * here Adapter Abstract Class
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Abstract: Here_Db_Adapter_Base
 */
abstract class Here_Db_Adapter_Base {
    /**
     * current adapter available flag
     *
     * @var bool
     */
    protected $_server_available = false;

    /**
     * return current adapter is available
     *
     * @return boolean
     */
    final public function is_available() {
        return $this->_server_available;
    }

    /**
     * connect to server, and depending on the return status set the
     * appropriate connection information($this->_server_available)
     *
     */
    abstract public function connect();

    /**
     * return server information, for example, Database version, Connection Descriptor, ...
     *
     * @return array
     */
    abstract public function server_info();

    /**
     * return last insert row id
     *
     * @return int
     */
    abstract public function last_insert_id();

    /**
     * execute escape for table name
     *
     * @param string $table
     * @return string
     */
    abstract public function escape_table_name($table);

    /**
     * based preBuilder generate SELECT syntax
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    abstract public function parse_select($pre_builder, $tables);

    /**
     * based pre_builder generate UPDATE syntax
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    abstract public function parse_update($pre_builder, $tables);

    /**
     * based pre_builder generate INSERT syntax
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    abstract public function parse_insert($pre_builder, $tables);

    /**
     * based pre_builder generate DELETE syntax
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    abstract public function parse_delete($pre_builder, $tables);

    /**
     * escape identifiers
     *
     * @param string $string
     * @return string
     */
    abstract public function escape_key($string);

    /**
     * escape identifiers
     *
     * @param string|Here_Db_Function_Base $value
     * @return string
     */
    abstract public function escape_value($value);

    /**
     * execute query
     *
     * @param string $query
     * @return bool query state
     */
    abstract public function query($query);

    /**
     * query result on success
     *
     * @var array
     */
    protected $_result = null;

    /**
     * result data internal pointer
     *
     * @var int
     */
    protected $_result_current_index = 0;

    /**
     * getting all/specified row($this->_result_current_index)
     *
     * @param array $keys
     * @return array
     */
    abstract public function fetch_assoc($keys = null);

    /**
     * fetch last query data
     *
     * @return array
     */
    abstract public function fetch_all();

    /**
     * reposition rows position indicator
     */
    final public function reset() {
        $this->_result_current_index = 0;
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
            throw new Here_Exceptions_OutOfRange('index out of range', 'Here:Db:Adapter:Base');
        }
    }

    /**
     * an object which represents the connection to a MySQL Server.
     *
     * @var mixed
     */
    protected $_connection = null;

    /**
     * Here_Db_Adapter_Base constructor.
     */
    public function __construct() {
    }
}
