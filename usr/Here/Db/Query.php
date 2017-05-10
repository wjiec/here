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
     * @var array
     */
    private $_table_name = array();

    /**
     * Here_Db_Query constructor.
     *
     * @param Here_Db_Adapter_Base $adapter_instance
     * @param string $table_prefix
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
            // empty is query all fields
            $this->_variable_pool['fields'][] = '*';
        } else {
            // foreach all field
            array_map(function($field) {
                // is array, array('key', 'as_name') => select `table.table_name` as `as_name` FROM ...
                if (is_array($field) && count($field) >= 2) {
                    $this->_variable_pool['fields'][$this->_complete_filed_name_filter($field[0])] =
                        $this->_adapter_instance->escape_key($field[1]);
                } else if (is_string($field)) {
                    $this->_variable_pool['fields'][] = $this->_complete_filed_name_filter($field);
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
        // assign 'insert' to base_action
        $this->_assign_base_action('insert');
        // initializing query variable
        $this->_variable_pool = array(
            'keys' => array(),
            'values' => array(),
            'sub_select' => null,
            'on_duplicate_update' => false
        );

        return $this;
    }

    /**
     * SQL Syntax: update
     *
     * @return Here_Db_Query
     */
    public function update() {
        // assign 'update' to base action
        $this->_assign_base_action('update');
        // initializing query variable
        $this->_variable_pool = array(
            'keys' => array(),
            'values' => array(),
            'where' => array(),
            'order' => array(),
            'limit' => array()
        );

        return $this;
    }

    /**
     * SQL Syntax: delete
     *
     * @return Here_Db_Query
     */
    public function delete() {
        $this->_assign_base_action('delete');

        return $this;
    }

    /**
     * alter table attributes
     *
     * @return Here_Db_Query
     */
    public function alter() {
        $this->_assign_base_action('alter');

        return $this;
    }

    /**
     * specified table, if table name is start with 'table.', than
     * $table_prefix will replace to 'table.', eg.
     *  $table_prefix = 'here_', 'table.users' will convert to 'here_users'
     * if table name is not start with 'table.', than table name will remain unchanged
     *
     * @param string $table
     * @param string $alias
     * @throws Here_Exceptions_ParameterError
     * @return Here_Db_Query
     */
    public function from($table, $alias = null) {
        // check base action is assigned
        $this->_check_base_action();
        // filter table name
        $table = $this->_table_name_filter($table, $alias);
        // fix prev select fields
        if ($alias && array_key_exists('fields', $this->_variable_pool)) {
            $this->_fix_prev_fields_named($table['table_name'], $table['alias_name']);
        }
        $this->_table_name[] = $table;

        return $this;
    }

    /**
     * alias of from method
     *
     * @param $table
     * @param null $alias
     * @return Here_Db_Query
     */
    public function into($table, $alias = null) {
        return $this->from($table, $alias);
    }

    /**
     * Syntax: Order by
     *
     * @param string $field_name
     * @param string $order
     * @return $this
     */
    public function order($field_name, $order = Here_Db_Helper::ORDER_ASC) {
        $this->_order_syntax('order', $field_name, $order);
        return $this;
    }

    /**
     * Syntax: where
     *
     * @param Here_Db_Expression $expression
     * @param string $relation
     * @return $this
     */
    public function where($expression, $relation = Here_Db_Helper::OPERATOR_AND) {
        $this->_expression_syntax('where', $expression, $relation);
        return $this;
    }

    /**
     * Syntax: Group by
     *
     * @param string $field_name
     * @param string $order
     * @return $this
     */
    public function group($field_name, $order = Here_Db_Helper::ORDER_ASC) {
        $this->_order_syntax('group', $field_name, $order);
        return $this;
    }

    /**
     * Syntax: Join
     *
     * @param string|array $table_name
     * @param string $join_type
     * @throws Here_Exceptions_ParameterError
     * @return $this
     */
    public function join($table_name, $join_type = Here_Db_Helper::JOIN_INNER) {
        if (is_array($table_name) && count($table_name) >= 2) {
            $table_name = $this->_table_name_filter($table_name[0], $table_name[1]);
            // fix prev complete fields name
            $this->_fix_prev_fields_named($table_name['table_name'], $table_name['alias_name']);
        } else if (!is_string($table_name)) {
            throw new Here_Exceptions_ParameterError("table name except array(\$table_name, \$alias) or string",
                'Here:Db:Query:join');
        }

        if (!in_array($join_type, array(Here_Db_Helper::JOIN_INNER, Here_Db_Helper::JOIN_LEFT, Here_Db_Helper::JOIN_RIGHT))) {
            throw new Here_Exceptions_ParameterError("join type invalid, except JOIN_INNER or JOIN_LEFT or JOIN_RIGHT",
                'Here:Db:Query:join');
        }

        // push variable pool
        $this->_variable_pool['join'][] = array('table_name' => $table_name, 'type' => $join_type);

        return $this;
    }

    /**
     * Syntax: on
     *
     * @param Here_Db_Expression $expression
     * @param string $relation
     * @return $this
     */
    public function on($expression, $relation = Here_Db_Helper::OPERATOR_AND) {
        $this->_expression_syntax('on', $expression, $relation);
        return $this;
    }

    /**
     * Syntax: having
     *
     * @param Here_Db_Expression $expression
     * @param string $relation
     * @return $this
     */
    public function having($expression, $relation = Here_Db_Helper::OPERATOR_AND) {
        $this->_expression_syntax('having', $expression, $relation);
        return $this;
    }

    /**
     * insert & update syntax, fields name
     *
     * @return $this
     * @throws Here_Exceptions_ParameterError
     * @return $this
     */
    public function keys(/* ... */) {
        // check base action is assigned
        $this->_check_base_action();
        // get parameters
        $keys = func_get_args();

        if (!empty($this->_variable_pool['values'])) {
            throw new Here_Exceptions_ParameterError("values is not empty",
                'Here:Db:Query:keys');
        }
        array_map(function($v) {
            $this->_variable_pool['keys'][] = $this->_complete_filed_name_filter($v);
        }, $keys);

        return $this;
    }

    /**
     * insert & update syntax, fields value
     *
     * @throws Here_Exceptions_BadQuery
     * @throws Here_Exceptions_ParameterError
     * @return $this
     */
    public function values(/* ... */) {
        // check base action is assigned
        $this->_check_base_action();
        // get parameters
        $values = func_get_args();

        if (empty($this->_variable_pool['keys'])) {
            throw new Here_Exceptions_ParameterError("keys is empty, set keys first",
                'Here:Db:Query:values');
        }

        if (count($this->_variable_pool['keys']) !== count($values)) {
            throw new Here_Exceptions_BadQuery("size of keys and values is difference",
                'Here:Db:Query:values');
        }

        $this->_variable_pool['values'][count($this->_variable_pool['values'])] = array_map(function($v) {
            return $this->_adapter_instance->escape_value($v);
        }, $values);

        return $this;
    }

    /**
     * one row data wrapper function
     *
     * @param array $one_row
     * @return $this
     */
    public function one_row(array $one_row) {
        $keys = array_keys($one_row);
        $values = array_values($one_row);
        // check keys is correct
        array_map(function($k) {
            if (!is_string($k)) {
                throw new Here_Exceptions_ParameterError("Key is not a string on inserts a row of data",
                    'Here:Db:Query:one_row');
            }
        }, $keys);

        // push to keys/values variable pool
        call_user_func_array(array($this, 'keys'), $keys);
        call_user_func_array(array($this, 'values'), $values);
        // chain-call
        return $this;
    }

    /**
     * insert...select syntax
     *
     * @param $select_query
     * @return $this
     * @throws Here_Exceptions_BadQuery
     * @throws Here_Exceptions_ParameterError
     */
    public function sub_select($select_query) {
        // check keys and values is empty
        if (!empty($this->_variable_pool['values'])) {
            throw new Here_Exceptions_BadQuery("to be using sub select, must be empty values",
                'Here:Db:Query:sub_select');
        }
        // check sub_query is base Here_Db_Query
        if (!($select_query instanceof Here_Db_Query)) {
            throw new Here_Exceptions_ParameterError("sub query is not base Here_Db_Query",
                'Here:Db:Query:sub_select');
        }
        // check base action is select
        if ($select_query->get_action() != 'select') {
            throw new Here_Exceptions_BadQuery("query object is not select action",
                'Here:Db:Query:sub_select');
        }
        // build sub-select
        $this->_variable_pool['sub_select'] = $select_query;

        return $this;
    }

    /**
     * toggle on_duplicate_update flag, default is false
     *
     * @return $this
     * @throws Here_Exceptions_BadQuery
     */
    public function toggle_on_duplicate_update() {
        // check base action is insert
        $this->_check_base_action('insert');
        // check one row
        if (($this->_variable_pool['on_duplicate_update'] == false) &&
            count($this->_variable_pool['values']) != 1) {
            //-------------------------------------------------
            throw new Here_Exceptions_BadQuery("if enable on_duplicate_update, values size must set 1",
                'Here:Db:Query:toggle_on_duplicate_update');
        }

        $this->_variable_pool['on_duplicate_update'] = !$this->_variable_pool['on_duplicate_update'];

        return $this;
    }

    /**
     * The maximum number of rows for the query limit
     *
     * @param int $limit_size
     * @throws Here_Exceptions_ParameterError
     * @return Here_Db_Query
     */
    public function limit($limit_size) {
        $this->_check_base_action();
        // check parameter type
        if (!is_int($limit_size)) {
            throw new Here_Exceptions_ParameterError('limit size except int type',
                'Here:Db:Query:limit');
        }
        // check limit can apply to this action
        if (!array_key_exists('limit', $this->_variable_pool)) {
            throw new Here_Exceptions_ParameterError('limit method may be not apply to this action',
                'Here:Db:Query:limit');
        }
        // all is ok
        $this->_variable_pool['limit'] = $limit_size;
        return $this;
    }

    /**
     * From what to begin querying
     *
     * @param int $offset
     * @throws Here_Exceptions_ParameterError
     * @return Here_Db_Query
     */
    public function offset($offset) {
        $this->_check_base_action();

        // check parameter type
        if (!is_int($offset)) {
            throw new Here_Exceptions_ParameterError('offset except int type',
                'Here:Db:Query:offset');
        }
        // check limit can apply to this action
        if (!array_key_exists('offset', $this->_variable_pool)) {
            throw new Here_Exceptions_ParameterError('offset may be not apply to this action',
                'Here:Db:Query:offset');
        }
        // all is ok
        $this->_variable_pool['offset'] = $offset;

        return $this;
    }

    /**
     * select limit+offset wrapper function
     *
     * @param int $page_index
     * @param int $page_size
     * @return Here_Db_Query
     * @throws Here_Exceptions_ParameterError
     */
    public function page($page_index, $page_size) {
        // check base action is assigned
        $this->_check_base_action();
        // check index type
        if (!is_int($page_index) || !is_int($page_size)) {
            throw new Here_Exceptions_ParameterError("",
                'Here:Db:Query:page');
        }
        // calc limit and offset
        $offset = ($page_index - 1) * $page_size;
        // bind parameter
        return $this->limit($page_size)->offset($offset);
    }

    /**
     * set current query attribute
     *
     * @param string $attribute_name
     * @param mixed $value
     * @return $this
     */
    public function attribute($attribute_name, $value) {
        var_dump($attribute_name, $value);
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
            case 'select': return $this->_adapter_instance->parse_select($this->_variable_pool, $this->_table_name);
            case 'insert': return $this->_adapter_instance->parse_insert($this->_variable_pool, $this->_table_name);
            case 'update': return $this->_adapter_instance->parse_update($this->_variable_pool, $this->_table_name);
            case 'delete': return $this->_adapter_instance->parse_delete($this->_variable_pool, $this->_table_name);
            case 'alter': return 'ALTER ';
            default:
                throw new Here_Exceptions_BadQuery('Operation is not defined or internal error',
                    'Error:Here:Db:Query:__toString');
        }
    }

    /**
     * getting base action name
     *
     * @return null|string
     */
    public function get_action() {
        return $this->_base_action;
    }

    /**
     * getting fields
     */
    public function select_get_fields() {
        $this->_check_base_action('select');

        return $this->_variable_pool['fields'];
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

    /**
     * filter complete field name, eg. table.users.last_login
     *
     * @param string $field_name
     * @return string
     * @throws Here_Exceptions_ParameterError
     */
    public function _complete_filed_name_filter($field_name) {
        if (!is_string($field_name)) {
            throw new Here_Exceptions_ParameterError("field name except string type",
                'Here:Db:Query:_complete_filed_name_filter');
        }

        if (strpos($field_name, 'table.') === false) {
            return $this->_adapter_instance->escape_key($field_name);
        }

        if (substr_count($field_name, '.') > 2) {
            throw new Here_Exceptions_ParameterError("field name invalid, too more char '.'",
                'Here:Db:Query:_complete_filed_name_filter');
        }

        list($table, $table_name, $field_name) = explode('.', $field_name);
        $table_name = $this->_table_name_filter(join('.', array($table, $table_name)), null);
        $field_name = $this->_adapter_instance->escape_table_name($field_name);

        // search if this table name is aliased in table_name
        foreach ($this->_table_name as $table) {
            if (is_array($table) && $table['table_name'] === $table_name) {
                $table_name = $table['alias_name'];
                break;
            }
        }
        // search if this table name is aliased in join_tables
        foreach ($this->_variable_pool['join'] as $join) {
            if (is_array($join['table_name']) && $join['table_name']['table_name'] === $table_name) {
                $table_name = $join['table_name']['alias_name'];
                break;
            }
        }

        return join('.', array($table_name, $field_name));
    }

    /**
     * filter table name
     *
     * @param string $table
     * @param string|null $alias
     * @throws Here_Exceptions_ParameterError
     * @return string|array
     */
    private function _table_name_filter($table, $alias) {
        // is start with `table.`
        if (strpos($table, 'table.') == 0) {
            // table.users.name ?
            if (strrpos($table, 'table.') != 0) {
                throw new Here_Exceptions_ParameterError("are you sure table name is {$table}",
                    'Here:Db:Query:_table_name_filter');
            }
            // replace table prefix
            $table = str_replace('table.', $this->_table_prefix, $table);
        }
        // escape complete table name
        $table_name = $this->_adapter_instance->escape_table_name($table);
        // check alias exists
        if ($alias == null) {
            return $table_name;
        } else {
            if (!is_string($alias)) {
                throw new Here_Exceptions_ParameterError("table alias name except string type",
                    'Here:Db:Query:_table_name_filter');
            }
            // alias is correct type
            return array(
                'table_name' => $table_name,
                'alias_name' => $this->_adapter_instance->escape_table_name($alias)
            );
        }
    }

    /**
     * internal method, push expression to correct variable pool
     *
     * @param $syntax_name
     * @param $expression
     * @param $relation
     * @return $this
     * @throws Here_Exceptions_ParameterError
     */
    private function _expression_syntax($syntax_name, $expression, $relation) {
        if (!($expression instanceof Here_Db_Expression)) {
            throw new Here_Exceptions_ParameterError("expression except Here_Db_Expression instance",
                "Here:Db:Query:{$syntax_name}");
        }

        // pre bind callback
        $expression = $expression->callback(array($this, '_complete_filed_name_filter'),
            array($this->_adapter_instance, 'escape_value'));

        if ($relation != Here_Db_Helper::OPERATOR_AND && $relation != Here_Db_Helper::OPERATOR_OR) {
            throw new Here_Exceptions_ParameterError("relation except Here_Db_Helper::OPERATOR_AND or Here_Db_Helper::OPERATOR_OR",
                "Here:Db:Query:{$syntax_name}");
        }

        if (!array_key_exists($syntax_name, $this->_variable_pool)) {
            throw new Here_Exceptions_ParameterError("expression key is non exists on variable pool",
                'Here:Db:Query:_expression_syntax');
        }

        $this->_variable_pool[$syntax_name][] = array('expression' => $expression, 'relation' => $relation);

        return $this;
    }

    /**
     * classify of order syntax
     *
     * @param $syntax_name
     * @param $field_name
     * @param string $order
     * @throws Here_Exceptions_ParameterError
     */
    private function _order_syntax($syntax_name, $field_name, $order = Here_Db_Helper::ORDER_ASC) {
        if (!is_string($field_name)) {
            throw new Here_Exceptions_ParameterError("field name except string type",
                "Here:Db:Query:{$syntax_name}");
        }

        if ($order != Here_Db_Helper::ORDER_ASC && $order != Here_Db_Helper::ORDER_DESC) {
            throw new Here_Exceptions_ParameterError("order must be Here_Db_Helper::ORDER_ASC or Here_Db_Helper::ORDER_DESC",
                "Here:Db:Query:{$syntax_name}");
        }

        $field_name = $this->_complete_filed_name_filter($field_name);
        $this->_variable_pool[$syntax_name][$field_name] = $order;
    }

    /**
     * fix complete field name if table name is alias
     *
     * @param string $table_name_p
     * @param string $alias_name_p
     */
    private function _fix_prev_fields_named($table_name_p, $alias_name_p) {
        // fix alias table name
        foreach ($this->_variable_pool['fields'] as $table_name => $alias_name) {
            // field name is not alias
            if (!is_string($table_name)) {
                $e_field_name = explode('.', $alias_name);
                // check field_name is complete name
                if (count($e_field_name) == 2) {
                    if ($e_field_name[0] == $table_name_p) {
                        // replace
                        $this->_variable_pool['fields'][$table_name] = join('.', array($alias_name_p, $e_field_name[1]));
                    }
                }
                // field name is alias
            } else {
                $e_field_name = explode('.', $table_name);
                // check field_name is complete name
                if (count($e_field_name) == 2) {
                    if ($e_field_name[0] == $table_name_p) {
                        // replace
                        $this->_variable_pool['fields'][join('.', array($alias_name_p, $e_field_name[1]))] =
                            $this->_variable_pool['fields'][$table_name];
                        // unset old
                        unset($this->_variable_pool['fields'][$table_name]);
                    }
                }
            }
        }
    }
}
