<?php
/**
 * Here Db Adapter MySQL
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Here_Db_Adapter_Mysql extends Here_Db_Adapter_Base {
    /**
     * Here_Db_Adapter_Base constructor
     *
     * @see Here_Db_Adapter_Base::__construct()
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * connect to server, and depending on the return status set the
     * appropriate connection information($this->_server_available)
     *
     * @see Here_Db_Adapter_Base::connect()
     */
    public function connect() {
        // if connected, than directly return
        if ($this->_server_available && $this->_connection != null) {
            return;
        }
        // getting server information
        $server_info = Here_Db_Helper::get_server(false, true);
        // using PDO
        if (class_exists('PDO')) {
            try {
                // using PDO connect to server
                $this->_connection = new PDO(Here_Db_Helper::array_to_dsn($server_info),
                    // authenticating of user;
                    $server_info['username'], $server_info['password'],
                    // PDO attributes
                    array(
                        // connect timeout=1s
                        PDO::ATTR_TIMEOUT => _here_database_connecting_timeout_,
                        // force lower case
                        PDO::ATTR_CASE => PDO::CASE_LOWER
                    )
                );
                // set connected flag
                $this->_server_available = true;
            } catch (PDOException $e) {
                // check connecting error
                throw new Here_Exceptions_ConnectingError($e->getMessage(),
                    'Here:Db:Adapter:Mysql:connect:PDO');
            }
        // using mysqli
        } else if (class_exists('mysqli')) {
            // init mysqli instance
            $this->_connection = mysqli_init();
            // set connect_timeout options
            $this->_connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, _here_database_connecting_timeout_);
            // real connecting to server
            $this->_connection->real_connect($server_info['host'], $server_info['username'], $server_info['password'],
                $server_info['dbname'], $server_info['port']);
            // check connecting error
            if ($this->_connection->connect_errno) {
                throw new Here_Exceptions_ConnectingError($this->_connection->connect_error,
                    'Here:Db:Adapter:Mysql:connect:mysqli');
            }
            // set connected flag
            $this->_server_available = true;
        } else {
            throw new Here_Exceptions_FatalError("PDO or mysqli doesn't exists, please enable mysqli or PDO extension",
                'Fatal:Here:Db:Adapter:Mysql');
        }
    }

    /**
     * return server information, for example, Database version, Connection Descriptor, ...
     *
     * @see Here_Db_Adapter_Base::server_info()
     *
     * @return array
     */
    public function server_info() {
        $this->connect();
        // PDO
        if ($this->_connection instanceof PDO) {
            return array(
                'client_server' => $this->_connection->getAttribute(constant('PDO::ATTR_CLIENT_VERSION')),
                'connection_status' => $this->_connection->getAttribute(constant('PDO::ATTR_CONNECTION_STATUS')),
                'server_info' => $this->_connection->getAttribute(constant('PDO::ATTR_SERVER_INFO')),
                'server_version' => $this->_connection->getAttribute(constant('PDO::ATTR_SERVER_VERSION')),
            );
        }
        // mysqli
        return array(
            'client_server' => $this->_connection->client_info,
            'connection_status' => $this->_connection->host_info,
            'server_info' => $this->_connection->stat,
            'server_version' => $this->_connection->server_info,
        );
    }

    /**
     * return last insert row id
     *
     * @see Here_Db_Adapter_Base::last_insert_id()
     *
     * @return int
     */
    public function last_insert_id() {
        $this->connect();
        // PDO
        if ($this->_connection instanceof PDO) {
            /* @var PDO $pdo_instance */
            $pdo_instance = $this->_connection;
            // return last insert id
            return $pdo_instance->lastInsertId();
        }
        // mysqli
        /* @var mysqli $mysqli_instance */
        $mysqli_instance = $this->_connection;
        // return last insert id
        return $mysqli_instance->insert_id;
    }

    /**
     * execute escape for table name
     *
     * @see Here_Db_Adapter_Base::escape_table_name()
     *
     * @param string $table
     * @throws Here_Exceptions_BadQuery
     * @return string
     */
    public function escape_table_name($table) {
        if (preg_match("/[\"';\-\+\=]+/", $table)) {
            throw new Here_Exceptions_BadQuery('table name is invalid',
                'Here:Db:Adapter:Mysql:escape_table_name');
        }

        return "`{$table}`";
    }

    /**
     * based preBuilder generate SELECT syntax
     *
     * @see Here_Db_Adapter_Base::parse_select()
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    public function parse_select($pre_builder, $tables) {
        // start
        $build_sql = "SELECT";

        // fields
        foreach ($pre_builder['fields'] as $field_name => $alias) {
            if (is_string($field_name)) {
                $build_sql .= " {$field_name} AS {$alias},";
            } else {
                $build_sql .= " {$alias},";
            }
        }
        $build_sql = rtrim($build_sql, ',');

        // table name
        $build_sql .= " FROM";
        foreach ($tables as $table) {
            if (is_array($table)) {
                $build_sql .= " {$table['table_name']} AS {$table['alias_name']},";
            } else {
                $build_sql .= " {$table}";
            }
        }
        $build_sql = rtrim($build_sql, ',');

        // join
        $build_sql .= $this->_build_join_syntax($pre_builder);

        // on
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'on');

        // where
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'where');

        // group
        $build_sql .= $this->_build_order_expression_syntax($pre_builder, 'group');

        // having
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'having');

        // order
        $build_sql .= $this->_build_order_expression_syntax($pre_builder, 'order');

        // limit
        if (array_key_exists('limit', $pre_builder) && is_int($pre_builder['limit'])) {
            $build_sql .= " LIMIT {$pre_builder['limit']}";
        }

        // offset
        if (array_key_exists('offset', $pre_builder) && is_int($pre_builder['offset'])) {
            $build_sql .= " OFFSET {$pre_builder['offset']}";
        }

        // end
        $build_sql .= ';';

        return $build_sql;
    }

    /**
     * based pre_builder generate UPDATE syntax
     *
     * @see Here_Db_Adapter_Base::parse_update()
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     * @throws Here_Exceptions_BadQuery
     */
    public function parse_update($pre_builder, $tables) {
        $build_sql = "UPDATE";

        // table name
        foreach ($tables as $table) {
            if (is_array($table)) {
                $build_sql .= " {$table['table_name']} AS {$table['alias_name']},";
            } else {
                $build_sql .= " {$table}";
            }
        }
        $build_sql = rtrim($build_sql, ',');

        // check key-value exists
        if (empty($pre_builder['keys']) || empty($pre_builder['values'])) {
            throw new Here_Exceptions_BadQuery("field name or value undefined",
                'Here:Db:Adapter:Mysql:parse_update');
        }

        // set
        $build_sql .= " SET";
        for ($i = 0, $s = count($pre_builder['keys']); $i < $s; ++$i) {
            $build_sql .= " {$pre_builder['keys'][$i]} = {$pre_builder['values'][0][$i]},";
        }
        $build_sql = rtrim($build_sql, ',');

        // where
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'where');

        // order
        $build_sql .= $this->_build_order_expression_syntax($pre_builder, 'order');

        // limit
        if (array_key_exists('limit', $pre_builder) && is_int($pre_builder['limit'])) {
            $build_sql .= " LIMIT {$pre_builder['limit']}";
        }

        // end
        $build_sql .= ";";

        return $build_sql;
    }

    /**
     * based pre_builder generate INSERT syntax
     *
     * @see Here_Db_Adapter_Base::parse_insert()
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     * @throws Here_Exceptions_BadQuery
     */
    public function parse_insert($pre_builder, $tables) {
        $build_sql = "INSERT INTO";

        // table name
        if (is_array($tables[0])) {
            $build_sql .= " {$tables[0]['table_name']}";
        } else {
            $build_sql .= " {$tables[0]}";
        }

        // check keys is empty
        if (empty($pre_builder['keys'])) {
            if ($pre_builder['sub_select'] == null) {
                throw new Here_Exceptions_BadQuery("empty keys",
                    'Here:Db:Adapter:Mysql:parse_insert');
            }
        }

        // keys
        if (!empty($pre_builder['keys'])) {
            $build_sql .= " (";
            $build_sql .= join(', ', $pre_builder['keys']);
            $build_sql .= ")";
        }

        if ($pre_builder['sub_select']) {
            /* @var Here_Db_Query $select_query */
            $select_query = $pre_builder['sub_select'];
            $build_sql .= " {$select_query->generate_sql()}";
            $build_sql = rtrim($build_sql, ';');
        } else {
            // values
            if (empty($pre_builder['values'])) {
                throw new Here_Exceptions_BadQuery("empty values",
                    'Here:Db:Adapter:Mysql:parse_insert');
            }
            $build_sql .= " VALUES";
            foreach ($pre_builder['values'] as $value) {
                $build_sql .= " (";
                $build_sql .= join(', ', $value);
                $build_sql .= "),";
            }
            $build_sql = rtrim($build_sql, ',');
        }

        /**
         * @TODO multi values update
         */
        if ($pre_builder['on_duplicate_update'] == true) {
            $build_sql .= " ON DUPLICATE KEY UPDATE";

            for ($i = 0, $s = count($pre_builder['keys']); $i < $s; ++$i) {
                $build_sql .= " {$pre_builder['keys'][$i]} = {$pre_builder['values'][0][$i]},";
            }
            $build_sql = rtrim($build_sql, ',');
        }

        // end
        $build_sql .= ";";

        return $build_sql;
    }

    /**
     * based pre_builder generate DELETE syntax
     *
     * @see Here_Db_Adapter_Base::parse_delete()
     *
     * @param array $pre_builder
     * @param array $tables
     * @return string
     */
    public function parse_delete($pre_builder, $tables) {
        $build_sql = "DELETE";

        // table name
        $build_sql .= " FROM";
        foreach ($tables as $table) {
            if (is_array($table)) {
                $build_sql .= " {$table['table_name']} AS {$table['alias_name']},";
            } else {
                $build_sql .= " {$table}";
            }
        }
        $build_sql = rtrim($build_sql, ',');

        // join
        $build_sql .= $this->_build_join_syntax($pre_builder);

        // on
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'on');

        // where
        $build_sql .= $this->_build_where_expression_syntax($pre_builder, 'where');

        // order
        $build_sql .= $this->_build_order_expression_syntax($pre_builder, 'order');

        // limit
        if (array_key_exists('limit', $pre_builder) && is_int($pre_builder['limit'])) {
            $build_sql .= " LIMIT {$pre_builder['limit']}";
        }

        // end
        $build_sql .= ";";

        return $build_sql;
    }

    /**
     * escape identifiers
     *
     * @see Here_Db_Adapter_Base::escape_key()
     *
     * @param string $string
     * @return string
     */
    public function escape_key($string) {
        return "`{$string}`";
    }

    /**
     * escape identifiers
     *
     * @see Here_Db_Adapter_Base::escape_value()
     *
     * @param string $value
     * @return string
     */
    public function escape_value($value) {
        return "'{$value}'";
    }

    /**
     * execute query
     *
     * @see Here_Db_Adapter_Base::query()
     *
     * @param string $query
     * @return bool query state
     */
    public function query($query) {
        $this->connect();

        return true;
    }

    /**
     * getting all/specified row($this->_result_current_index)
     *
     * @see Here_Db_Adapter_Base::fetch_assoc()
     *
     * @param array $keys
     * @return array
     */
    public function fetch_assoc($keys = null) {
        return array();
    }

    /**
     * fetch last query data
     *
     * @see Here_Db_Adapter_Base::fetch_all()
     *
     * @return array
     */
    public function fetch_all() {
        return array();
    }

    /**
     * build sql part for where expression with syntax
     *
     * @param array $pre_builder
     * @param string $syntax
     * @return string
     */
    private function _build_where_expression_syntax($pre_builder, $syntax) {
        $build_sql = " ";

        if (empty($pre_builder[$syntax])) {
            return "";
        }

        $build_sql .= strtoupper($syntax);
         foreach ($pre_builder[$syntax] as $where_expression) {
            /* @var Here_Db_Expression $expression */
            list($expression, $relation) = array($where_expression['expression'], $where_expression['relation']);

            $build_expression = $expression->build(null, array($this, '_fix_value_escape'));
            $build_sql .= " {$build_expression} {$relation}";
        }

        if ($pre_builder[$syntax][count($pre_builder[$syntax]) - 1]['relation'] == Here_Db_Helper::OPERATOR_AND) {
            $build_sql = rtrim($build_sql, Here_Db_Helper::OPERATOR_AND);
        } else {
            $build_sql = rtrim($build_sql, Here_Db_Helper::OPERATOR_OR);
        }
        $build_sql = rtrim($build_sql);

        return rtrim($build_sql);
    }

    /**
     * build sql for order classify syntax [order by], [group by]
     *
     * @param array $pre_builder
     * @param string $syntax
     * @return string
     */
    private function _build_order_expression_syntax($pre_builder, $syntax) {
        $build_sql = " ";

        if (!empty($pre_builder[$syntax])) {
            $build_sql .= strtoupper($syntax);
            $build_sql .= " BY";
            foreach ($pre_builder[$syntax] as $field_name => $order) {
                $build_sql .= " {$field_name} {$order},";
            }
        }
        $build_sql = rtrim($build_sql, ',');

        return rtrim($build_sql);
    }

    /**
     * build join syntax
     *
     * @param array $pre_builder
     * @return string
     */
    private function _build_join_syntax($pre_builder) {
        $build_sql = "";
        // start
        foreach ($pre_builder['join'] as $join) {
            $build_sql .= " {$join['type']}";
            if (is_array($join['table_name'])) {
                $build_sql .= " {$join['table_name']['table_name']} AS {$join['table_name']['alias_name']}";
            } else {
                $build_sql .= " {$join['table_name']}";
            }
        }
        // end
        return $build_sql;
    }

    /**
     * if value is field name, then escape that
     *
     * @param string $value
     * @return string|int
     */
    public function _fix_value_escape($value) {
        if (strpos($value, 'table.') === 0) {
            return Here_Db_Expression::USING_KEY_ESCAPE_CALLBACK;
        }

        return $this->escape_value($value);
    }
}
