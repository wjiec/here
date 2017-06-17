<?php
/**
 * Here Db Helper
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class _Here_Db_Helper
 *
 * Db Helper for any database
 */
class Here_Db_Helper extends Here_Abstracts_Widget {
    /**
     * table prefix,(multi blog supported)
     *
     * @var string|null
     */
    private $_table_prefix = null;

    /**
     * adapter instance
     *
     * @var Here_Db_Adapter_Base|null
     */
    private $_adapter_instance = null;

    /**
     * Here_Db_Helper constructor.
     *
     * @param string $table_prefix
     * @throws Here_Exceptions_ParameterError|Here_Exceptions_FatalError|Here_Exceptions_BadQuery
     */
    public function __construct($table_prefix) {
        // parent-class constructor
        parent::__construct();
        // current widget name
        $this->set_widget_name('Database Helper');
        // check server is initial
        if (!self::$_database_server || empty(self::$_database_server)) {
            throw new Here_Exceptions_FatalError('must be initializing server first',
                'Fatal:Here:Db:Helper:__construct');
        }
        // check parameter legal
        if ($table_prefix == null || is_string($table_prefix)) {
            $this->_table_prefix = $table_prefix;
        } else {
            throw new Here_Exceptions_ParameterError('table prefix except string or null',
                'Here:Db:Helper:__construct');
        }
        // standard adapter name
        $adapter_name = ucfirst(strtolower(self::$_database_server['driver']));
        $adapter_class = join(array('Here_Db_Adapter_', $adapter_name));
        // check adapter is exists
        if (!class_exists($adapter_class)) {
            throw new Here_Exceptions_BadQuery('Bad adapter name, adapter not found',
                'Here:Db:Query:__construct');
        }
        /* @var Here_Db_Adapter_Base */
        $this->_adapter_instance = new $adapter_class(self::$_database_server);
    }

    /**
     * select syntax
     *
     * @return Here_Db_Query
     */
    public function select() {
        return $this->sql_generator()->select(func_get_args());
    }

    /**
     * insert syntax
     *
     * @return Here_Db_Query
     */
    public function insert() {
        return $this->sql_generator()->insert();
    }

    /**
     * update syntax
     *
     * @return Here_Db_Query
     */
    public function update() {
        return $this->sql_generator()->update();
    }

    /**
     * delete syntax
     *
     * @return Here_Db_Query
     */
    public function delete() {
        return $this->sql_generator()->delete();
    }

    /**
     * alter table attributes
     *
     * @return Here_Db_Query
     */
    public function alter() {
        return $this->sql_generator()->alter();
    }

    /**
     * execute sql
     *
     * @param string|Here_Db_Query $query
     * @return Here_Db_Result
     */
    public function query($query) {
        $action = null;
        // quote query object
        if (is_string($query)) {
            $query = trim($query);
            $action = strtolower(substr($query, 0, strpos($query, ' ')));
        } else if ($query instanceof Here_Db_Query) {
            $action = $query->get_action();
            $query = $query->__toString();
        }
        // execute sql
        $this->_adapter_instance->query($query, $action);
        // build Here_Db_Result instance
        return new Here_Db_Result(
            // result set
            $this->_adapter_instance->fetch_all(),
            // affected roes count
            $this->_adapter_instance->affected_rows(),
            // last insert id
            $this->_adapter_instance->last_insert_id(),
            // query string
            $this->_adapter_instance->query_string()
        );
    }

    /**
     * base sql generator
     *
     * @throws Here_Exceptions_FatalError
     * @return Here_Db_Query
     */
    private function sql_generator() {
        if (!($this->_adapter_instance instanceof Here_Db_Adapter_Base)) {
            throw new Here_Exceptions_FatalError("adapter invalid",
                'Here:Db:Helper:sql_generator');
        }
        return new Here_Db_Query($this->_adapter_instance, $this->_table_prefix);
    }

    /**
     * according parameter $dsn to create server connect information
     *
     * $dsn Formatter: driver:host=[host];port=[post];dbname=[database_name];charset=[charset];
     *  For Example:
     *      Mysql: mysql:host=localhost;port=3306;dbname=here_blog;charset=utf8
     *
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     *
     * @throws Here_Exceptions_ParameterError
     */
    public static function init_server($dsn, $username = null, $password = null) {
        if (!is_string($dsn) || ($username != null && !is_string($username)) ||
            ($password != null && !is_string($password))) {
            //---------------------------------------------
            throw new Here_Exceptions_ParameterError('parameter except string',
                'Here:Db:Helper:init_server');
        }

        list($driver, $database_information) = explode(':', $dsn, 2);
        self::$_database_server['driver'] = trim(strtolower($driver));

        $database_information = explode(';', $database_information);
        foreach ($database_information as $kvp) {
            if (strpos($kvp, '=')) {
                list($key, $value) = explode('=', $kvp);
                self::$_database_server[trim($key)] = trim($value);
            }
        }

        if (!array_key_exists('host', self::$_database_server) ||
            !array_key_exists('dbname', self::$_database_server)) {
            //---------------------------------------------------------
            throw new Here_Exceptions_ParameterError('miss host or dbname field',
                'Fatal:Here:Db:Helper:init_server');
        }

        if ($username == null || is_string($username)) {
            self::$_database_server['username'] = $username;
        } else {
            throw new Here_Exceptions_ParameterError('username except string or null',
                'Here:Db:Helper:init_server');
        }

        if ($password == null || is_string($password)) {
            self::$_database_server['password'] = $password;
        } else {
            throw new Here_Exceptions_ParameterError('password except string or null',
                'Here:Db:Helper:init_server');
        }

        if (!array_key_exists('port', self::$_database_server)) {
            self::$_database_server['port'] = null;
        } else {
            self::$_database_server['port'] = intval(self::$_database_server['port']);
        }

        if (!array_key_exists('charset', self::$_database_server)) {
            // in database, utf-8 is alias to utf8
            self::$_database_server['charset'] = str_replace('-', '', _here_default_charset_);
        }
    }

    /**
     * get database server information
     *
     * @param bool $get_dsn
     * @param bool $get_array
     * @return array|string
     */
    public static function get_server($get_dsn = true, $get_array = false) {
        $dsn = self::array_to_dsn(self::$_database_server);

        // both dsn and explode array
        if ($get_dsn == true && $get_array == true) {
            return array($dsn, self::$_database_server);
        }
        // only array
        if ($get_array == true) {
            return self::$_database_server;
        }
        // only dsn, [default]
        return $dsn;
    }

    /**
     * from server information(array) convert to dsn string
     *
     * @param array $information
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    public static function array_to_dsn($information) {
        // check driver exists
        if (!array_key_exists('driver', $information)) {
            throw new Here_Exceptions_FatalError("server information driver not found",
                'Here:Db:Helper:array_to_dsn');
        }
        $dsn = $information['driver'] . ':';

        // check host|dbname|charset exists
        if (!array_key_exists('host', $information) || !array_key_exists('dbname', $information)
            || !array_key_exists('charset', $information)) {
            //--------------------------------------------------------------------------
            throw new Here_Exceptions_FatalError("server information lack some field(s)",
                'Here:Db:Helper:array_to_dsn');
        }
        $dsn .= "host={$information['host']};";
        $dsn .= (array_key_exists('port', $information)) ? ("port={$information['port']};") : ('');
        $dsn .= "dbname={$information['dbname']};";
        $dsn .= "charset={$information['charset']};";

        return $dsn;
    }

    /**
     * wrapper function
     *
     * @return array
     */
    public function get_adapter_info() {
        return $this->_adapter_instance->server_info();
    }

    /**
     * all server information
     *
     * @var array
     */
    private static $_database_server;

    /**
     * MySQL Adapter
     */
    const ADAPTER_MYSQL      = 'MySQL';

    /**
     * PostgreSQL Adapter
     */
    const ADAPTER_PGSQL      = 'PostgreSQL';

    /**
     * SQLite Adapter
     */
    const ADAPTER_SQLITE     = 'SQLite';

    /**
     * Data: DEFAULT
     */
    const DATA_DEFAULT       = '\x44\x45\x46\x41\x55\x4C\x54';

    /**
     * Data: NULL
     */
    const DATA_NULL          = '\x4E\x55\x4C\x4C';

    /**
     * Sort Type: DESC
     *
     * DESC: 9 8 7 6 5 4 3 2 1 0
     */
    const ORDER_DESC         = 'DESC';

    /**
     * Sort Type: ASC [default]
     *
     * ASC: 0 1 2 3 4 5 6 7 8 9
     */
    const ORDER_ASC          = 'ASC';

    /**
     * AND operator, && [default]
     */
    const OPERATOR_AND       = 'AND';

    /**
     * OR operator, ||
     */
    const OPERATOR_OR        = 'OR';

    /**
     * JOIN syntax type: inner join [default]
     */
    const JOIN_INNER         = 'INNER JOIN';

    /**
     * JOIN syntax type: left join
     */
    const JOIN_LEFT          = 'LEFT JOIN';

    /**
     * JOIN syntax type: right join
     */
    const JOIN_RIGHT          = 'RIGHT JOIN';
}
