<?php
/**
 * Here Db Query
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Db_Query {
    /**
     * pre builder
     *
     * @var array
     */
    private $_pre_builder = array(
        'fields' => array(),
        'rows'   => array('keys' => array(), 'values' => array()),
        'order'  => array(),
        'where'  => array(),
        'group'  => array(),
        'join'   => array(),
        'on'     => array(),
        'having' => array(),
        'set'    => array(),
        'using'  => null,
        'limit'  => null,
        'offset' => null,
        'insertSelect' => null
    );

    /**
     * adapter instance, reference
     *
     * @var Here_Abstracts_Adapter
    */
    private $_adapter_instance = null;

    /**
     * helper instance
     *
     * @var Helper
     */
    private $_helper_instance = null;

    /**
     * default table name
     *
     * @var string
     */
    private $_table = null;

    private $_single_table_mode = true;

    private $_query_action = null;

    public function __construct(&$adapter_instance, &$helper_instance) {
        if ($adapter_instance instanceof Here_Abstracts_Adapter) {
            $this->_adapter_instance = $adapter_instance;
        }

        if ($helper_instance instanceof Here_Db_Helper) {
            $this->_helper_instance  = $helper_instance;
        }
    }

    /**
     * SQL Basic Syntax: SELECT
     *
     * @param array $fields
     * @return Here_Db_Query
     */
    public function select(array $fields) {
        $this->_query_action = 'SELECT';

        if (empty($fields)) {
            $this->_pre_builder['fields'][] = '*';
        } else {
            foreach ($fields as &$field) {
                if (is_array($field)) {
                    $field[0] = $this->_adapter_instance->table_filter($field[0]);
                    $field[1] = $this->_adapter_instance->quote_key($field[1]);
                } else {
                    // check is full field name, like table.articles.contents
                    if (strpos($field, 'table.') === 0) {
                        $field = $this->_adapter_instance->table_filter($field);
                    } else {
                        $field = $this->_adapter_instance->quote_key($field);
                    }
                }
            }

            $this->_pre_builder['fields'] = array_merge($this->_pre_builder['fields'], $fields);
        }

        return $this;
    }

    /**
     * SQL Basic Syntax: UPDATE
     *
     * @param string $table
     */
    public function update($table) {
        $this->_query_action = 'UPDATE';
        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));

        return $this;
    }

    /**
     * SQL Basic Syntax: INSERT
     *
     * @param string $table
     */
    public function insert($table) {
        $this->_query_action = 'INSERT';
        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));

        return $this;
    }

    public function insertSelect($query) {
        if (!($query instanceof Here_Db_Query)) {
            throw new \Exception('SDB: Query: insertSelect params invalid', 1996);
        }
        $this->_pre_builder['insertSelect'] = $query;

        return $this;
    }

    /**
     * SQL Basic Syntax: DELETE
     *
     * @param string $table
     */
    public function delete($tables, $using = null) {
        $this->_query_action = 'DELETE';
        $this->_table = is_string($tables) ? $this->_adapter_instance->table_filter($tables) :
            ((is_array($tables) ? (array_map(function($t) { return $this->_adapter_instance->table_filter($t); }, $tables)) :
                strval($tables)));
        $this->_pre_builder['using'] = ($using === null) ? '' : $this->_adapter_instance->table_filter(strval($using));

        return $this;
    }

    public function from($table, $single_table = true) {
        $this->_table = $this->_adapter_instance->table_filter(is_string($table) ? $table : strval($table));

        return $this;
    }

    public function limit($rows) {
        $this->_pre_builder['limit'] = intval($rows);

        return $this;
    }

    public function offset($offset) {
        $this->_pre_builder['offset'] = intval($offset);

        return $this;
    }

    public function page($index, $size) {
        $this->offset(intval($size) * (max(intval($index), 1) - 1));
        $this->limit($size);

        return $this;
    }

    public function rows(array $rows) {
        $keys = array_map(function($key) { return $this->_adapter_instance->quote_key($key); }, array_keys($rows));
        $vals = array_map(function($val) { return $this->_adapter_instance->quote_value($val); }, array_values($rows));

        if (empty($this->_pre_builder['rows']['keys'])) {
            $this->_pre_builder['rows']['keys'] = $keys;
        }
        $this->_pre_builder['rows']['values'][] = $vals;

        return $this;
    }

    public function keys() {
        if (!empty($this->_pre_builder['rows']['keys'])) {
            return $this;
        }

        $keys = func_get_args();
        foreach ($keys as &$key) {
            $key = $this->_adapter_instance->quote_key($key);
        }
        $this->_pre_builder['rows']['keys'] = $keys;

        return $this;
    }

    public function values() {
        if (empty($this->_pre_builder['rows']['keys'])) {
            throw new \Exception('SDB: Query: keys not exists', 1996);
        }

        $rows = array_map(function($val) { return is_array($val) ? $val : array($val); }, func_get_args());
        foreach ($rows as &$row) {
            if (count($row) != count($this->_pre_builder['rows']['keys'])) {
                throw new \Exception('SDB: Query: values size and keys not matched', 1996);
            }

            foreach ($row as &$val) {
                if ($val === Here_Db_Helper::DATA_DEFAULT || $val === Here_Db_Helper::DATA_NULL) {
                    $val = stripcslashes($val);
                    continue;
                }
                $val = $this->_adapter_instance->quote_value($val);
            }
        }
        $this->_pre_builder['rows']['values'] = array_merge($this->_pre_builder['rows']['values'], $rows);

        return $this;
    }

    public function order($field, $sort = Here_Db_Helper::ORDER_ASC) {
        if (!is_string($field) || !in_array($sort, array(Here_Db_Helper::ORDER_DESC, Here_Db_Helper::ORDER_ASC))) {
            throw new \Exception('SDB: Query: in ORDER params invalid', 1996);
        }

        $this->_pre_builder['order'][] = array('field' => $this->_adapter_instance->table_filter($field), 'sort' => $sort);
        return $this;
    }

    public function where($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
        if (!($expression instanceof Here_Db_Expression)) {
            throw new \Exception('SDB: Query: in WHERE params invalid', 1996);
        }
        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
            throw new \Exception('SDB: Query: conjunction invalid', 1996);
        }

        $this->_pre_builder['where'][] = array_merge(array( 'conjunction' => $conjunction),
                $expression->expression(array($this->_adapter_instance, 'tableFilter'), array($this->_adapter_instance, 'quoteValue')));
        return $this;
    }

    public function group($field, $sort = Here_Db_Helper::ORDER_ASC) {
        if (!is_string($field) || !in_array($sort, array(Here_Db_Helper::ORDER_DESC, Here_Db_Helper::ORDER_ASC))) {
            throw new \Exception('SDB: Query: in GROUP params invalid', 1996);
        }

        $this->_pre_builder['group'][] = array('field' => $this->_adapter_instance->table_filter($field), 'sort' => $sort);
        return $this;
    }

    public function join($tables, $references = Here_Db_Helper::JOIN_INNER) {
        if (!in_array($references, array(Here_Db_Helper::JOIN_INNER, Here_Db_Helper::JOIN_LEFT, Here_Db_Helper::JOIN_RIGHT))) {
            throw new \Exception('SDB: Query: in JOIN params invalid', 1996);
        }

        // TODO. A table reference can be aliased using tbl_name AS alias_name or tbl_name alias_name
        if (is_string($tables)) {
            $tables = array($this->_adapter_instance->table_filter($tables));
        } else if (is_array($tables)) {
            $tables = array_map(function($val) { return (is_string($val)) ? $this->_adapter_instance->table_filter($val) : null; }, $tables);
        }

        $this->_pre_builder['join'][] = array('references' => $references, 'tables' => $tables);
        return $this;
    }

    public function on($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
        if (!($expression instanceof Here_Db_Expression)) {
            throw new \Exception('SDB: Query: in ON params invalid', 1996);
        }

        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
            throw new \Exception('SDB: Query: conjunction invalid', 1996);
        }

        $lval = explode('.', $expression->lval(array($this->_adapter_instance, 'tableFilter')));
        $rval = explode('.', $expression->rval(array($this->_adapter_instance, 'tableFilter')));
        $references = array(
                'lval' => array('table' => $lval[0], 'field' => $lval[1]),
                'rval' => array('table' => $rval[0], 'field' => $rval[1])
        );

        $this->_pre_builder['on'][] = array_merge($references, array('operator' => $expression->operator(), 'conjunction' => $conjunction));
        return $this;
    }

    public function having($expression, $conjunction = Here_Db_Helper::CONJUNCTION_AND) {
        if (!($expression instanceof Here_Db_Expression)) {
            throw new \Exception('SDB: Query: in HAVING params invalid', 1996);
        }
        if (!in_array($conjunction, array(Here_Db_Helper::CONJUNCTION_AND, Here_Db_Helper::CONJUNCTION_OR))) {
            throw new \Exception('SDB: Query: conjunction invalid', 1996);
        }

        $this->_pre_builder['having'][] = array_merge(array( 'conjunction' => $conjunction),
                $expression->expression(array($this->_adapter_instance, 'tableFilter'), array($this->_adapter_instance, 'quoteValue')));
        return $this;
    }

    public function set(array $kvps) {
        foreach ($kvps as $key => $value) {
            if (!is_string($key)) {
                throw new \Exception('SDB: Query: set params invalid', 1996);
            }

            if (in_array($value, array(Here_Db_Helper::DATA_DEFAULT, Here_Db_Helper::DATA_NULL))) {
                $this->_pre_builder['set'] = array_merge($this->_pre_builder['set'],
                        array($this->_adapter_instance->quote_key($key) => stripcslashes($value)));
            } else {
                $this->_pre_builder['set'] = array_merge($this->_pre_builder['set'],
                        array($this->_adapter_instance->quote_key($key) => $this->_adapter_instance->quote_value($value)));
            }
        }

        return $this;
    }

    public function __toString() {
        switch ($this->_query_action) {
            case 'SELECT': return $this->_adapter_instance->parse_select($this->_pre_builder, $this->_table); break;
            case 'UPDATE': return $this->_adapter_instance->parse_update($this->_pre_builder, $this->_table); break;
            case 'INSERT': return $this->_adapter_instance->parse_insert($this->_pre_builder, $this->_table); break;
            case 'DELETE': return $this->_adapter_instance->parse_delete($this->_pre_builder, $this->_table); break;
            default: throw new \Exception('SDB: Query: unknown query action or undefined action', 1996);
        }
    }

    public function query() {
        $this->_helper_instance->connect();

        return $this->_adapter_instance->query($this->__toString());
    }
}
