<?php
/**
 * Here Db Adapper Base Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

abstract class Here_Abstracts_Adapter {
    /**
     * Is adapter avaliable
     *
     * @return boolean
     */
    abstract public function available();

    /**
     * connect to database
     *
     * @param string $host
     * @param string|int $port
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $charset
     * @return boolean connect state
     * @throws \Exception connect error information
    */
    abstract public function connect($host, $port, $user, $password, $database, $charset = 'utf8');

    /**
     * return database information
    */
    abstract public function server_info();

    /**
     * return last insert row id
    */
    abstract public function last_insert_id();

    /**
     * return last query affected rows
    */
    abstract public function affected_rows();

    /**
     * execute failter for table name
     *
     * @param string $table
     * @return string
    */
    abstract public function table_filter($table);

    /**
     * based preBuilder generate SELECT syntax
     *
     * @param array $preBuilder
     * @return string
    */
    abstract public function parse_select($pre_builder, $table);

    /**
     * based preBuilder generate UPDATE syntax
     *
     * @param string $preBuilder
     * @return string
    */
    abstract public function parse_update($pre_builder, $table);

    /**
     * based preBuilder generate INSERT syntax
     *
     * @param string $preBuilder
     * @return string
    */
    abstract public function parse_insert($pre_builder, $table);

    /**
     * based preBuilder generate DELETE syntax
     *
     * @param string $preBuilder
     * @return string
    */
    abstract public function parse_delete($pre_builder, $table);

    /**
     * quoted identifiers
     *
     * @param string $string
    */
    abstract public function quote_key($string);

    /**
     * quoted identifiers
     *
     * @param string $string
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
     * save query data
     *
     * @var array|object
    */
    protected $_result = null;

    /**
     * result query data internal pointer
     *
     * @var int
     */
    protected $_result_current_index = 0;

    /**
     * fetch last query data
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
     */
    final public function seek($index) {
        if (is_array($this->_result) && count($this->_result) > $index && $index > 0) {
            $this->_result_current_index = $index;
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
    protected $_instance = null;

    /**
     * is connect
     *
     * @var boolean
     */
    protected $_connect_flag = false;

    /**
     * default constructor
     *
     * @param string $table_prefix
     */
    public function __construct($table_prefix) {
        $this->_table_prefix = is_string($table_prefix) ? $table_prefix : strval($table_prefix);
    }
}
