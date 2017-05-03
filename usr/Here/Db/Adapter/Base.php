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
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     */
    abstract public function connect($dsn, $username = null, $password = null);

    /**
     * return server information, for example, Database version, Connection Descriptor, ...
     *
     * @return string
     */
    abstract public function server_info();

    /**
     * return last insert row id
     *
     * @return int
     */
    abstract public function last_insert_id();

    /**
     * return last query affected rows
     *
     * @return int
     */
    abstract public function affected_rows();

    /**
     * execute filter for table name
     *
     * @param string $table
     * @return string
     */
    abstract public function table_filter($table);

    /**
     * based preBuilder generate SELECT syntax
     *
     * @param array $pre_builder
     * @param string $table
     * @return string
     */
    abstract public function parse_select($pre_builder, $table);

    /**
     * based pre_builder generate UPDATE syntax
     *
     * @param string $pre_builder
     * @param string $table
     * @return string
     */
    abstract public function parse_update($pre_builder, $table);

    /**
     * based pre_builder generate INSERT syntax
     *
     * @param string $pre_builder
     * @param string $table
     * @return string
     */
    abstract public function parse_insert($pre_builder, $table);

    /**
     * based pre_builder generate DELETE syntax
     *
     * @param string $pre_builder
     * @param string $table
     * @return string
     */
    abstract public function parse_delete($pre_builder, $table);

    /**
     * quoted identifiers
     *
     * @param string $string
     * @return string
     */
    abstract public function quote_key($string);

    /**
     * quoted identifiers
     *
     * @param string $string
     * @return string
     */
    abstract public function quote_value($string);

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
     * table prefix
     *
     * @var string
     */
    protected $_table_prefix = null;

    /**
     * an object which represents the connection to a MySQL Server.
     *
     * @var mixed
     */
    protected $_connection = null;

    /**
     * Here_Db_Adapter_Base constructor
     *
     * @param string$table_prefix
     */
    public function __construct($table_prefix) {
        $this->_table_prefix = is_string($table_prefix) ?: strval($table_prefix);
    }
}
