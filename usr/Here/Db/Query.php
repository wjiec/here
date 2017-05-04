<?php
/**
 * Here Db Query
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class Here_Db_Query
 *
 * Database Helper Core Widget, build complete sql.
 *
 */
class Here_Db_Query {
    /**
     * current driver adapter for database
     *
     * @var Here_Db_Adapter_Base
     */
    private $_adapter_instance;

    /**
     * base action, select/update/insert/delete
     *
     * @var null|string
     */
    private $_base_action = null;

    /**
     * Store all the variables used to build the SQL
     *
     * @var array|null
     */
    private $_variable_pool;

    /**
     * prefix of table name
     *
     * @var string
     */
    private $_table_prefix;

    /**
     * Table name of the currently executing query
     *
     * @var string|null
     */
    private $_table_name;

    /**
     * Here_Db_Query constructor.
     *
     * @param Here_Db_Adapter_Base $adapter_instance
     * @throws Here_Exceptions_ParameterError
     */
    public function __construct(&$adapter_instance, $table_prefix) {
        if ($adapter_instance instanceof Here_Db_Adapter_Base) {
            $this->_adapter_instance = $adapter_instance;
        } else {
            throw new Here_Exceptions_ParameterError('adapter instance is not base Here_Db_Adapter_Base',
                'Here:Db:Query:__construct');
        }

        if (!is_string($table_prefix)) {
            throw new Here_Exceptions_ParameterError('prefix of table name except string type',
                'Here:Db:Query:__construct');
        }
        $this->_table_prefix = $table_prefix;
    }

    /**
     * SQL Syntax: select
     *
     * @param array $fields
     * @return Here_Db_Query
     */
    public function select(array $fields) {
        // assign 'select' to base_action
        $this->_assign_base_action('select');
        // initializing query variable
        $this->_variable_pool = array(
            'fields' => array(),
            'order'  => array(),
            'where'  => array(),
            'group'  => array(),
            'join'   => array(),
            'on'     => array(),
            'having' => array(),
            'limit'  => null,
            'offset' => null
        );

        // initializing select field
        if (empty($fields)) {
            $this->_variable_pool['fields'][] = '*';
        } else {
            array_map(function($field) {
                // is array, array('key', 'as_name') => select `table.table_name` as `as_name` FROM ...
                if (is_array($field) && count($field) >= 2) {
                    // @TODO escape key and value
                    $this->_variable_pool['fields'][$field[0]] = $field[1];
                } else if (is_string($field)) {
                    // @TODO escape key
                    $this->_variable_pool['fields'][] = $field;
                } else {
                    // got invalid file type
                    throw new Here_Exceptions_BadQuery("field(`{$field}`) except string type",
                        'Here:Db:Query:select');
                }
            }, $fields);
        }

        return $this;
    }

    /**
     * SQL Syntax: insert
     *
     * @return Here_Db_Query
     */
    public function insert() {
        $this->_base_action = 'insert';

        return $this;
    }

    /**
     * SQL Syntax: update
     *
     * @return Here_Db_Query
     */
    public function update() {
        $this->_base_action = 'update';

        return $this;
    }

    /**
     * SQL Syntax: delete
     *
     * @return Here_Db_Query
     */
    public function delete() {
        $this->_base_action = 'delete';

        return $this;
    }

    /**
     * alter table attributes
     *
     * @return Here_Db_Query
     */
    public function alter() {

        return $this;
    }

    /**
     * specified table, if table name is start with 'table.', than
     * $table_prefix will replace to 'table.', eg.
     *  $table_prefix = 'here_', 'table.users' will convert to 'here_users'
     * if table name is not start with 'table.', than table name will remain unchanged
     *
     * @param string $table
     * @throws Here_Exceptions_ParameterError
     * @return Here_Db_Query
     */
    public function from($table) {
        // check base action is assigned
        $this->_check_base_action();
        // is start with `table.`
        if (strpos($table, 'table.') == 0) {
            if (strrpos($table, 'table.') != 0) {
                throw new Here_Exceptions_ParameterError("are you sure table name is {$table}",
                    'Here:Db:Query:from');
            }
            // replace table prefix
            $table = str_replace('table.', $this->_table_prefix, $table);
        }
        // escape complete table name
        $this->_table_name = $this->_adapter_instance->escape_table_name($table);;
        return $this;
    }

    /**
     * The maximum number of rows for the query limit
     *
     * @param int $limit_size
     * @return Here_Db_Query
     */
    public function limit($limit_size) {
        $this->_check_base_action('select');

        return $this;
    }

    /**
     * From what to begin querying
     *
     * @param int $offset
     * @return Here_Db_Query
     */
    public function offset($offset) {
        $this->_check_base_action('select');

        return $this;
    }

    /**
     * generate sql
     *
     * @return string
     */
    public function generate_sql() {
        return $this->__toString();
    }

    /**
     * generate sql
     *
     * @return string
     * @throws Here_Exceptions_BadQuery
     */
    public function __toString() {
        switch ($this->_base_action) {
            case 'select': return 'SELECT ';
            case 'insert': return 'INSERT ';
            case 'update': return 'UPDATE ';
            case 'delete': return 'DELETE ';
            default:
                throw new Here_Exceptions_BadQuery('Operation is not defined or internal error',
                    'Error:Here:Db:Query:__toString');
        }
    }

    /**
     * check base action is legal
     *
     * @param string|null $needle_action
     *
     * @throws Here_Exceptions_BadQuery
     */
    private function _check_base_action($needle_action = null) {
        if ($needle_action == null) {
            if ($this->_base_action == null) {
                throw new Here_Exceptions_BadQuery('bad query generator, must be specified base action first',
                    'Here:Db:Query:_check_base_action');
            }
        } else {
            if ($this->_base_action != $needle_action) {
                throw new Here_Exceptions_BadQuery('bad query generator, this operator not use for current action',
                    'Here:Db:Query:_check_base_action');
            }
        }
    }

    /**
     * assign action
     *
     * @param string $action
     * @throws Here_Exceptions_BadQuery
     */
    private function _assign_base_action($action) {
        if ($this->_base_action != null) {
            throw new Here_Exceptions_BadQuery("bad query generator, base action is specified to {$this->_base_action}",
                'Here:Db:Query:_assign_base_action');
        }
        $this->_base_action = $action;
    }

    private function _assign_table_name($table) {

    }
}

//class Here_Db_Query {
//    /**
//     * pre builder
//     *
//     * @var array
//     */
//    private $_pre_builder = array(
//        'fields' => array(),
//        'rows'   => array('keys' => array(), 'values' => array()),
//        'order'  => array(),
//        'where'  => array(),
//        'group'  => array(),
//        'join'   => array(),
//        'on'     => array(),
//        'having' => array(),
//        'set'    => array(),
//        'using'  => null,
//        'limit'  => null,
//        'offset' => null,
//        'insertSelect' => null
//    );
//
//    /**
//     * adapter instance, reference
//     *
//     * @var Here_Abstracts_Adapter
//    */
//    private $_adapter_instance = null;
//
//    /**
//     * helper instance
//     *
//     * @var Helper
//     */
//    private $_helper_instance = null;
//
//    /**
//     * default table name
//     *
//     * @var string
//     */
//    private $_table = null;
//
//    private $_single_table_mode = true;
//
//    private $_query_action = null;
//
//    public function __construct(&$adapter_instance, &$helper_instance) {
//        if ($adapter_instance instanceof Here_Abstracts_Adapter) {
//            $this->_adapter_instance = $adapter_instance;
//        }
//
//        if ($helper_instance instanceof Here_Db_Helper) {
//            $this->_helper_instance  = $helper_instance;
//        }
//    }
//
//    /**
//     * SQL Basic Syntax: SELECT
//     *
//     * @param array $fields
//     * @return Here_Db_Query
//     */
//    public function select(array $fields) {
//        $this->_query_action = 'SELECT';
//
//        if (empty($fields)) {
//            $this->_pre_builder['fields'][] = '*';
//        } else {
//            foreach ($fields as &$field) {
//                if (is_array($field)) {
//                    $field[0] = $this->_adapter_instance->table_filter($field[0]);
//                    $field[1] = $this->_adapter_instance->quote_key($field[1]);
//                } else {
//                    // check is full field name, like table.articles.contents
//                    if (strpos($field, 'table.') === 0) {
//                        $field = $this->_adapter_instance->table_filter($field);
//                    } else {
//                        $field = $this->_adapter_instance->quote_key($field);
//                    }
//                }
//            }
//
//            $this->_pre_builder['fields'] = array_merge($this->_pre_builder['fields'], $fields);
//        }
//
//        return $this;
//    }
//
//    /**
//     * SQL Basic Syntax: UPDATE
//     *
//     * @param string $table
//     */
//    public function update($table) {
//        $this->_query_action = 'UPDATE';
//        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));
//
//        return $this;
//    }
//
//    /**
//     * SQL Basic Syntax: INSERT
//     *
//     * @param string $table
//     */
//    public function insert($table) {
//        $this->_query_action = 'INSERT';
//        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));
//
//        return $this;
//    }
//
//    public function insertSelect($query) {
//        if (!($query instanceof Here_Db_Query)) {
//            throw new \Exception('SDB: Query: insertSelect params invalid', 1996);
//        }
//        $this->_pre_builder['insertSelect'] = $query;
//
//        return $this;
//    }
//
//    /**
//     * SQL Basic Syntax: DELETE
//     *
//     * @param string $table
//     */
//    public function delete($tables, $using = null) {
//        $this->_query_action = 'DELETE';
//        $this->_table = is_string($tables) ? $this->_adapter_instance->table_filter($tables) :
//            ((is_array($tables) ? (array_map(function($t) { return $this->_adapter_instance->table_filter($t); }, $tables)) :
//                strval($tables)));
//        $this->_pre_builder['using'] = ($using === null) ? '' : $this->_adapter_instance->table_filter(strval($using));
//
//        return $this;
//    }
//
//    public function from($table, $single_table = true) {
//        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));
//
//        return $this;
//    }
//
//    public function limit($rows) {
//        $this->_pre_builder['limit'] = intval($rows);
//
//        return $this;
//    }
//
//    public function offset($offset) {
//        $this->_pre_builder['offset'] = intval($offset);
//
//        return $this;
//    }
//
//    public function page($index, $size) {
//        $this->offset(intval($size) * (max(intval($index), 1) - 1));
//        $this->limit($size);
//
//        return $this;
//    }
//
//    public function rows(array $rows) {
//        $keys = array_map(function($key) { return $this->_adapter_instance->quote_key($key); }, array_keys($rows));
//        $vals = array_map(function($val) { return $this->_adapter_instance->quote_value($val); }, array_values($rows));
//
//        if (empty($this->_pre_builder['rows']['keys'])) {
//            $this->_pre_builder['rows']['keys'] = $keys;
//        }
//        $this->_pre_builder['rows']['values'][] = $vals;
//
//        return $this;
//    }
//
//    public function keys() {
//        if (!empty($this->_pre_builder['rows']['keys'])) {
//            return $this;
//        }
//
//        $keys = func_get_args();
//        foreach ($keys as &$key) {
//            $key = $this->_adapter_instance->quote_key($key);
//        }
//        $this->_pre_builder['rows']['keys'] = $keys;
//
//        return $this;
//    }
//
//    public function values() {
//        if (empty($this->_pre_builder['rows']['keys'])) {
//            throw new \Exception('SDB: Query: keys not exists', 1996);
//        }
//
//        $rows = array_map(function($val) { return is_array($val) ? $val : array($val); }, func_get_args());
//        foreach ($rows as &$row) {
//            if (count($row) != count($this->_pre_builder['rows']['keys'])) {
//                throw new \Exception('SDB: Query: values size and keys not matched', 1996);
//            }
//
//            foreach ($row as &$val) {
//                if ($val === Here_Db_Helper::DATA_DEFAULT || $val === Here_Db_Helper::DATA_NULL) {
//                    $val = stripcslashes($val);
//                    continue;
//                }
//                $val = $this->_adapter_instance->quote_value($val);
//            }
//        }
//        $this->_pre_builder['rows']['values'] = array_merge($this->_pre_builder['rows']['values'], $rows);
//
//        return $this;
//    }
//
//    public function order($field, $sort = Here_Db_Helper::ORDER_ASC) {
//        if (!is_string($field) || !in_array($sort, array(Here_Db_Helper::ORDER_DESC, Here_Db_Helper::ORDER_ASC))) {
//            throw new \Exception('SDB: Query: in ORDER params invalid', 1996);
//        }
//
//        $this->_pre_builder['order'][] = array('field' => $this->_adapter_instance->table_filter($field), 'sort' => $sort);
//        return $this;
//    }
//
//    public function where($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
//        if (!($expression instanceof Here_Db_Expression)) {
//            throw new \Exception('SDB: Query: in WHERE params invalid', 1996);
//        }
//        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
//            throw new \Exception('SDB: Query: conjunction invalid', 1996);
//        }
//
//        $this->_pre_builder['where'][] = array_merge(array( 'conjunction' => $conjunction),
//                $expression->expression(array($this->_adapter_instance, 'tableFilter'), array($this->_adapter_instance, 'quoteValue')));
//        return $this;
//    }
//
//    public function group($field, $sort = Here_Db_Helper::ORDER_ASC) {
//        if (!is_string($field) || !in_array($sort, array(Here_Db_Helper::ORDER_DESC, Here_Db_Helper::ORDER_ASC))) {
//            throw new \Exception('SDB: Query: in GROUP params invalid', 1996);
//        }
//
//        $this->_pre_builder['group'][] = array('field' => $this->_adapter_instance->table_filter($field), 'sort' => $sort);
//        return $this;
//    }
//
//    public function join($tables, $references = Here_Db_Helper::JOIN_INNER) {
//        if (!in_array($references, array(Here_Db_Helper::JOIN_INNER, Here_Db_Helper::JOIN_LEFT, Here_Db_Helper::JOIN_RIGHT))) {
//            throw new \Exception('SDB: Query: in JOIN params invalid', 1996);
//        }
//
//        // TODO. A table reference can be aliased using tbl_name AS alias_name or tbl_name alias_name
//        if (is_string($tables)) {
//            $tables = array($this->_adapter_instance->table_filter($tables));
//        } else if (is_array($tables)) {
//            $tables = array_map(function($val) { return (is_string($val)) ? $this->_adapter_instance->table_filter($val) : null; }, $tables);
//        }
//
//        $this->_pre_builder['join'][] = array('references' => $references, 'tables' => $tables);
//        return $this;
//    }
//
//    public function on($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
//        if (!($expression instanceof Here_Db_Expression)) {
//            throw new \Exception('SDB: Query: in ON params invalid', 1996);
//        }
//
//        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
//            throw new \Exception('SDB: Query: conjunction invalid', 1996);
//        }
//
//        $lval = explode('.', $expression->lval(array($this->_adapter_instance, 'tableFilter')));
//        $rval = explode('.', $expression->rval(array($this->_adapter_instance, 'tableFilter')));
//        $references = array(
//                'lval' => array('table' => $lval[0], 'field' => $lval[1]),
//                'rval' => array('table' => $rval[0], 'field' => $rval[1])
//        );
//
//        $this->_pre_builder['on'][] = array_merge($references, array('operator' => $expression->operator(), 'conjunction' => $conjunction));
//        return $this;
//    }
//
//    public function having($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
//        if (!($expression instanceof Here_Db_Expression)) {
//            throw new \Exception('SDB: Query: in HAVING params invalid', 1996);
//        }
//        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
//            throw new \Exception('SDB: Query: conjunction invalid', 1996);
//        }
//
//        $this->_pre_builder['having'][] = array_merge(array( 'conjunction' => $conjunction),
//                $expression->expression(array($this->_adapter_instance, 'tableFilter'), array($this->_adapter_instance, 'quoteValue')));
//        return $this;
//    }
//
//    public function set(array $kvps) {
//        foreach ($kvps as $key => $value) {
//            if (!is_string($key)) {
//                throw new \Exception('SDB: Query: set params invalid', 1996);
//            }
//
//            if (in_array($value, array(Here_Db_Helper::DATA_DEFAULT, Here_Db_Helper::DATA_NULL))) {
//                $this->_pre_builder['set'] = array_merge($this->_pre_builder['set'],
//                        array($this->_adapter_instance->quote_key($key) => stripcslashes($value)));
//            } else {
//                $this->_pre_builder['set'] = array_merge($this->_pre_builder['set'],
//                        array($this->_adapter_instance->quote_key($key) => $this->_adapter_instance->quote_value($value)));
//            }
//        }
//
//        return $this;
//    }
//
//    public function __toString() {
//        switch ($this->_query_action) {
//            case 'SELECT': return $this->_adapter_instance->parse_select($this->_pre_builder, $this->_table); break;
//            case 'UPDATE': return $this->_adapter_instance->parse_update($this->_pre_builder, $this->_table); break;
//            case 'INSERT': return $this->_adapter_instance->parse_insert($this->_pre_builder, $this->_table); break;
//            case 'DELETE': return $this->_adapter_instance->parse_delete($this->_pre_builder, $this->_table); break;
//            default: throw new \Exception('SDB: Query: unknown query action or undefined action', 1996);
//        }
//    }
//
//    public function query() {
//        $this->_helper_instance->connect();
//
//        return $this->_adapter_instance->query($this->__toString());
//    }
//}