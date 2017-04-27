<?php
/**
 * Here Db Helper
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Db_Helper {
    /**
     * server information
     * @var array
     */
    private static $_server = array();

    /**
     * driver information
     *
     * @var array
    */
    private static $_driver = null;

    /**
     * strict mode flag
     *
     * @var boolean
     */
    private static $_adapter_strict_mode = true;

    /**
     * adapter instance
     *
     * @var Here_Abstracts_Adapter
     */
    private $_adapter = null;

    /**
     * table prefix
     *
     * @var string
     */
    private $_table_prefix = null;

    /**
     * pre-query set
     *
     * @var array
     */
    private $_pre_query_pool = array();

    /**
     * Helper constructor
     *
     * @param string $adapter
     * @param string $table_prefix
    */
    public function __construct($table_prefix, $adapter = null) {
        if (!is_string($table_prefix)) {
            throw new \Exception('SDB: table prefix except string', 1996);
        }
        $this->_table_prefix = $table_prefix;

        # default using mysql adapter, if mysql is disable, that throw Exception
        if ($adapter == null) {
            if (in_array(self::ADAPTER_MYSQL, self::$_driver)) {
                $adapter = self::ADAPTER_MYSQL;
            } else {
                throw new \Exception('SDB: default database adapter(MySQL) not found', 1996);
            }
        }

        if (!in_array($adapter, array_values(self::$_driver))) {
            throw new \Exception('SDB: adapter or driver invalid', 1996);
        }

        # if adapter available, creating the instance
        $adapter = "Here_Db_Adapter_{$adapter}";
        if (!call_user_func(array(($this->_adapter = new $adapter($this->_table_prefix)), 'available'))) {
            unset($this->_adapter);
            throw new \Exception('SDB: adapter is not available', 1996);
        }
    }

    /**
     * disable strict mode for adapter mapping
     */
    public static function disable_strict_mode() {
        self::$_adapter_strict_mode = true;
    }

    /**
     * server information
     *
     * @param string $host
     * @param string|int $port
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $charset
     */
    public static function server($host, $port, $user, $password, $database, $charset = 'utf8') {
        if (self::$_driver === null) {
            self::init_driver();
        }

        $args = array_map(function($value) {
            if (!is_string($value)) {
                return strval($value);
            }
            return $value;
        }, get_defined_vars());

        self::$_server[] = array_merge($args, array( '__connectable__' => false ));
    }

    public static function clean_server() {
        return array_splice(self::$_server, 0, count(self::$_server));
    }

    /**
     * private: initialize driver
     * create driver => adapter mapping
     *
     * @throws \Exception
     */
    private static function init_driver() {
        $loaded = get_loaded_extensions();

        if (in_array('PDO', $loaded) && extension_loaded('PDO')) {
            $filtered = array_filter($loaded, function($value) {
                return strpos($value, 'pdo_') === 0 || in_array($value, array('mysqli', 'oci'));
            });

            # Database module support is not enabled. raise Exception
                if (empty($filtered)) {
                    throw new \Exception('SDB: database module support is not enabled', 1996);
                }

                # Create driver => adapter mapping
                foreach ($filtered as $driver) {
                    switch ($driver) {
                        case 'pdo_mysql'  : self::$_driver[$driver] = self::ADAPTER_PDO_MYSQL;  break;
                        case 'mysqli'     : self::$_driver[$driver] = self::ADAPTER_MYSQL;      break;
                        case 'pdo_oci'    : self::$_driver[$driver] = self::ADAPTER_PDO_ORACLE; break;
                        case 'oci'        : self::$_driver[$driver] = self::ADAPTER_ORACLE;     break;
                        case 'pgsql'      : self::$_driver[$driver] = self::ADAPTER_PGSQL;      break;
                        case 'pdo_pgsql'  : self::$_driver[$driver] = self::ADAPTER_PDO_PGSQL;  break;
                        case 'sqlite'     : self::$_driver[$driver] = self::ADAPTER_SQLITE;     break;
                        case 'pdo_sqlite' : self::$_driver[$driver] = self::ADAPTER_SQLITE;     break;
                        default: if (self::$_adapter_strict_mode === true) {
                            throw new \Exception("SDB: fatal error, driver({$driver}) invalid.\n", 1996);
                        }
                    }
                }
        }
    }

    public function last_insert_id() {
        return $this->_adapter->last_insert_id();
    }

    /**
     * return Query instance
     *
     * @return \SDB\Query
     */
    public function builder() {
        return new Here_Db_Query($this->_adapter, $this);
    }

    /**
     * SQL Basic Syntax: SELECT
     */
    public function select() {
        return $this->builder()->select(func_get_args());
    }

    /**
     * SQL Basic Syntax: UPDATE
     *
     * @param string $table
     */
    public function update($table) {
        return $this->builder()->update($table);
    }

    /**
     * SQL Basic Syntax: INSERT
     *
     * @param string $table
     */
    public function insert($table) {
        return $this->builder()->insert($table);
    }

    /**
     * SQL Basic Syntax: DELETE
     *
     * @param string $table
     */
    public function delete($tables, $using = null) {
        return $this->builder()->delete($tables, $using);
    }

    /**
     * execute query
     *
     * @param string|SDB\Query $table
     */
    public function query($query) {
        $query = trim($query instanceof Here_Db_Query ? $query->__toString() : $query);

        $this->connect();
        return $this->_adapter->query($query);
    }

    public function fetch_assoc($keys = null) {
        return $this->_adapter->fetch_assoc($keys);
    }

    public function fetch_all() {
        return $this->_adapter->fetch_all();
    }

    public function affected_rows() {
        return $this->_adapter->affected_rows();
    }

    public function connect() {
        return call_user_func_array(array($this->_adapter, 'connect'), self::$_server[array_rand(self::$_server, 1)]);
    }

    public function server_info() {
        return $this->_adapter->server_info();
    }

    public function reset() {
        $this->_adapter->reset();
    }

    public function seek($index) {
        $this->_adapter->seek(is_int($index) ? $index : intval($index));
    }

    public function register_pre_query($alias, $query) {
        if (!is_string($alias)) {
            throw new \Exception('SDB: alias name must string type', 1996);
        }

        if (!($query instanceof Here_Db_Query)) {
            throw new \Exception('SDB: pre query statement must Query type', 1996);
        }

        if (array_key_exists($alias, $this->_pre_query_pool)) {
            throw new \Exception('SDB: alias name exists in pool', 1996);
        }

        $this->_pre_query_pool[$alias] = $query;
    }

    public function execute_pre_query($alias) {
        if (!array_key_exists($alias, $this->_pre_query_pool)) {
            throw new \Exception('SDB: alias name not found in preQueryPool', 1996);
        }

        $this->query($this->_pre_query_pool[$alias]);
        return new Here_Db_Result($this->fetch_all(), $this->affected_rows());
    }

    public function execute_all() {
        $resultSet = array();

        foreach ($this->_pre_query_pool as $key => $value) {
            $resultSet[$key] = $this->execute_pre_query($key);
        }

        return $resultSet;
    }

    # Database: MySQL
    const ADAPTER_PDO_MYSQL  = 'PDO_MySQL';

    # Database: MySQL, PDO
    const ADAPTER_MYSQL      = 'MySQL';

    # Database: SQL Server
    const ADAPTER_SQL_SERVER = 'SQL_SERVER';

    # Database: Oracle
    const ADAPTER_PDO_ORACLE = 'PDO_ORACLE';

    # Database: Oracle, PDO
    const ADAPTER_ORACLE     = 'ORACLE';

    # Database: SQLite
    const ADAPTER_SQLITE     = 'SQLITE';

    # Database: PostgreSQL
    const ADAPTER_PGSQL      = 'PGSQL';

    # Database: PostgreSQL, PDO
    const ADAPTER_PDO_PGSQL  = 'PDO_PGSQL';

    # CRUD Operator: Insert
    const OPERATOR_INSERT    = 'INSERT';

    # CRUD Operator: Select
    const OPERATOR_SELECT    = 'SELECT';

    # CRUD Operator: Update
    const OPERATOR_UPDATE    = 'UPDATE';

    # CRUD Operator: Delete
    const OPERATOR_DELETE    = 'DELETE';

    # Operator: Change
    const OPERATOR_CHANGE    = 'CHANGE';

    # Data Type: DEFAULT
    const DATA_DEFAULT       = '\x44\x45\x46\x41\x55\x4C\x54';

    #Data Type: NULL
    const DATA_NULL          = '\x4E\x55\x4C\x4C';

    # Sort Type: DESC
    const ORDER_DESC         = 'DESC';

    # Sort Type: ASC
    const ORDER_ASC          = 'ASC';

    # Conjunction: AND
    const CONJUNCTION_AND    = 'AND';

    # Conjunction: OR
    const CONJUNCTION_OR     = 'OR';

    # Join: INNER JOIN
    const JOIN_INNER         = 'INNER JOIN';

    # Join: LEFT JOIN
    const JOIN_LEFT          = 'LEFT JOIN';

    # Join: RIGHT JOIN
    const JOIN_RIGHT          = 'RIGHT JOIN';
}
