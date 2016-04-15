<?php
/**
 * @author ShadowMan
 * @package here::Db_Query
 */
class Db_Query {
    /**
     * pretreatment
     * @var array
     */
    private $_preBuilder = array();

    private $_action = null;

    /**
     * table name
     * @string unknown
     */
    private $_table = null;

    /**
     * table prefix
     * @string unknown
     */
    private $_prefix = null;

    /**
     * Mysqli instance
     * @var Db_Mysql
     */
    private $_instance = null;

    public function __construct($prefix, &$instance) {
        $this->_prefix = $prefix;
        $this->_instance = $instance;

        self::initBuilder();
    }

    private function initBuilder() {
        $this->_preBuilder = array(
            'rows'   => array('keys' => array(), 'values' => array()),
            'fields' => array(),
            'join'   => array(),
            'group'  => array(),
            'having' => array(),
            'where'  => array(),
            'order'  => array(),
            'limit'  => null,
            'offset' => null
        );
    }

    private function tableFilter($table) {
        return '`' . ((strpos($table, 'table.') === 0) ? substr_replace($table, $this->_prefix, 0, 6) : $table) . '`';
    }

    public function rows(array $rows) {
        $keys = array_keys($rows);
        $vals = array_values($rows);

        if (empty($this->_preBuilder['rows']['keys'])) {
            $this->_preBuilder['rows']['keys'] = $keys;
        }
        $this->_preBuilder['rows']['values'] = array_merge($this->_preBuilder['rows']['values'], $vals);
        return $this;
    }

    public function keys(array $keys) {
        if (!is_array($keys) && !empty($this->_preBuilder['rows']['keys'])) {
            return $this;
        }

        foreach ($keys as &$key) {
            $key = $this->_instance->escapeKey($key);
        }
        $this->_preBuilder['rows']['keys'] = $keys;
        return $this;
    }

    public function values() {
        $rows = array_map(array('Db_Query', 'valuesFilter'), func_get_args());

        foreach ($rows as &$row) {
            foreach ($row as &$val) {
                $val = $this->_instance->escapeValue($val);
            }
        }
        $this->_preBuilder['rows']['values'] = array_merge($this->_preBuilder['rows']['values'], $rows);
        return $this;
    }

    public function select($fields) {
        $this->_action = Db::SELECT;

        if ($fields[0] == null) {
            $this->_preBuilder['fields'][] = '*';
        } else {
            foreach ($fields as $val) {
                $this->_preBuilder['fields'][] = $this->_instance->escapeKey($val);
            }
        }
        return $this;
    }

    public function from($table) {
        $this->_table = $this->tableFilter($table);
        return $this;
    }

    public function update($table) {
        $this->_action = Db::UPDATE;
        $this->_table  = $this->tableFilter($table);
        return $this;
    }

    public function delete($table) {
        $this->_action = Db::DELETE;
        $this->_table  = $this->tableFilter($table);
        return $this;
    }

    public function insert($table) {
        $this->_action = Db::INSERT;
        $this->_table  = $this->tableFilter($table);
        return $this;
    }

    public function limit($rows) {
        $this->_preBuilder['limit'] = intval($rows);
        return $this;
    }

    public function offset($offset) {
        $this->_preBuilder['offset'] = intval($offset);
        return $this;
    }

    public function page($index, $size) {
        $this->offset(intval($size) * (max(intval($index), 1) - 1));
        $this->limit($size);
        return $this;
    }

    public function group($by, $sort = Db::DESC) {
        if (!is_string($by) || !in_array($sort, array(Db::DESC, Db::ASC))) {
            return $this;
        }
        $this->_preBuilder['group'][] = array('by' => $by, 'sort' => $sort);
        return $this;
    }

    /**
     * Mysql HAVING Syntax
     * eg. having('name', Db::OP_EQUAL, 'user');
     *     having('pawd', Db::OP_EQUAL, 'pawd', Db::RS_AND)
     * 
     * @param string $object
     * @param string $op
     * @param mixed $condition
     * @param string $relation
     * @return Db_Query
     */
    public function having($object, $op, $condition, $relation = Db::RS_AND) {
        if (!is_scalar($object) || !is_string($condition)
                || !in_array($op, array(Db::OP_EQUAL, Db::OP_GT, Db::OP_GT_EQUAL, Db::OP_LT, Db::OP_LT_EQUAL, Db::OP_NOT_EQUAL))
                || !in_array($relation, array(Db::RS_AND, Db::RS_OR))) {
            return $this;
        }
        $this->_preBuilder['having'][] = array('object' => $object, 'op' => $op, 'condition' => $condition, 'relation' => $relation);
        return $this;
    }

    public function where($object, $op, $condition, $relation = Db::RS_AND) {
        if (!is_scalar($object) || !is_string($condition)
                || !in_array($op, array(Db::OP_EQUAL, Db::OP_GT, Db::OP_GT_EQUAL, Db::OP_LT, Db::OP_LT_EQUAL, Db::OP_NOT_EQUAL))
                || !in_array($relation, array(Db::RS_AND, Db::RS_OR))) {
            return $this;
        }
        $this->_preBuilder['where'][] = array('object' => $object, 'op' => $op, 'condition' => $condition, 'relation' => $relation);
        return $this;
    }

    public function order($by, $sort = Db::DESC) {
        if (!is_string($by) || !in_array($sort, array(Db::DESC, Db::ASC))) {
            return $this;
        }
        $this->_preBuilder['order'][] = array('by' => $by, 'sort' => $sort);
        return $this;
    }

    public function getAction() {
        return $this->_action;
    }

    public function __toString() {
        switch ($this->_action) {
            case Db::DELETE: return $this->parseDelete(); break;
            case Db::INSERT: return $this->parseInsert(); break;
            case Db::SELECT: return $this->parseSelect(); break;
            case Db::UPDATE: return $this->parseDelete(); break;
            default: throw new Exception('FATAL ERROR: Query ACTION not defined', 0);
        }
    }

    private function valuesFilter($value) {
        if (!is_array($value)) {
            return array($value);
        }
        return $value;
    }

    private function parseSelect() {
        $sql = 'SELECT ';
    }

    private function parseUpdate() {
        $sql = 'UPDATE ';
    }

    private function parseInsert() {
        $sql = 'INSERT INTO ';
        $sql .= $this->_table;

        if (!empty($this->_preBuilder['rows']['keys'])) {
            $sql .= ' ( ' . implode(', ', array_values($this->_preBuilder['rows']['keys'])) . ' )';
        }

        $sql .= ' VALUES ';
        if (empty(($this->_preBuilder['rows']['values']))) {
            return null;
        } else {
            foreach ($this->_preBuilder['rows']['values'] as $row) {
                $sql .= '( ' . implode(', ', array_values($row)) . ' ), ';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 2); // Remove unnecessary ', '

        return $sql;
    }

    private function parseDelete() {
        $sql = 'DELETE ';
    }
}

?>