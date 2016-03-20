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
    private $_preBuilder;

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
     * 
     * @var Widget_Db
     */
    private $_instance = null;

    public function __construct($prefix, &$instance) {
        $this->_prefix = $prefix;
        $this->_instance = $instance;

        self::initBuilder();
    }

    private function initBuilder() {
        $this->_preBuilder = [
            'rows' => [],
            'fields' => [],
            'group' => null,
            'having' => null,
            'where' => null,
            'order' => null,
            'limit' => null,
            'offset' => null
        ];
    }

    private function tableFilter($table) {
        return '`' . ((strpos($table, 'table.') === 0) ? substr_replace($table, $this->_prefix, 0, 6) : $table) . '`';
    }

    public function getAction() {
        return ($this->_action) ? $this->_action : null;
    }

    public function rows(array $rows) {
        foreach ($rows as $key => $val) {
            $this->_preBuilder['rows'][$this->_instance->escapeKey($key)] = $this->_instance->escapeValue($val);
        }
        return $this;
    }

    /**
     * select
     * @return Db_Query
     */
    public function select() {
        $this->_action = Db::SELECT;

        $args = func_get_arg(0); var_dump($args);
        if ($args[0] == null) {
            $this->_preBuilder['fields'][] = '*';
        } else {
            foreach ($args as $val) {
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
        if (!is_string($by)) {
            return $this;
        } else {
            $by = $this->_instance->escapeKey($by);
        }
        if (empty($this->_preBuilder['group'])) {
            $this->_preBuilder['group'] = (in_array($sort, [ Db::DESC, Db::ASC ])) ? " GROUP BY {$by} {$sort}" : null;
        } else {
            $this->_preBuilder['group'] .= (in_array($sort, [ Db::DESC, Db::ASC ])) ? ", {$by} {$sort} " : null;
        }
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
        $object = $this->_instance->escapeKey($object);
        $condition = $this->_instance->escapeValue($condition);

        if (!is_string($object) || !in_array($op, [Db::OP_EQUAL, Db::OP_NOT_EQUAL, Db::OP_GT, Db::OP_GT_EQUAL, Db::OP_LT, Db::OP_LT_EQUAL])) {
            return $this;
        }
        if (empty($this->_preBuilder['having'])) {
            $this->_preBuilder['having'] = " HAVING {$object} {$op} {$condition} ";
        } else {
            $this->_preBuilder['having'] .= "{$relation} {$object} {$op} {$condition} ";
        }
        return $this;
    }

    public function where($object, $op, $condition, $relation = Db::RS_AND) {
        $object = $this->_instance->escapeKey($object);
        $condition = $this->_instance->escapeValue($condition);
    
        if (!is_string($object) || !in_array($op, [Db::OP_EQUAL, Db::OP_NOT_EQUAL, Db::OP_GT, Db::OP_GT_EQUAL, Db::OP_LT, Db::OP_LT_EQUAL])) {
            return $this;
        }
        if (empty($this->_preBuilder['where'])) {
            $this->_preBuilder['where'] = " WHERE {$object} {$op} {$condition} ";
        } else {
            $this->_preBuilder['where'] .= "{$relation} {$object} {$op} {$condition} ";
        }
        return $this;
    }

    public function order($by, $sort = Db::DESC) {
        if (!is_string($by)) {
            return $this;
        } else {
            $by = $this->_instance->escapeKey($by);
        }
        if (empty($this->_preBuilder['order'])) {
            $this->_preBuilder['order'] = (in_array($sort, [ Db::DESC, Db::ASC ])) ? " ORDER BY {$by} {$sort}" : null;
        } else {
            $this->_preBuilder['order'] .= (in_array($sort, [ Db::DESC, Db::ASC ])) ? ", {$by} {$sort} " : null;
        }
        return $this;
    }

    public function __toString() {
        switch ($this->_action) {
            case Db::DELETE:
                break;
            case Db::INSERT:
                return 'INSERT INTO ' . $this->_table
                    . '( ' . implode(', ', array_keys($this->_preBuilder['rows'])) . ' )'
                    . ' VALUES '
                    . '( ' . implode(', ', array_values($this->_preBuilder['rows'])) . ' )';
            case Db::SELECT:
                $limit = (strlen($this->_preBuilder['limit'] == 0)) ? NULL : ' LIMIT ' . $this->_preBuilder['limit'];
                $offset = (strlen($this->_preBuilder['offset']) == 0) ? NULL : ' OFFSET ' . $this->_preBuilder['offset'];

                return 'SELECT ' . implode(',', array_values($this->_preBuilder['fields'])) . ' FROM ' . $this->_table
                    . $this->_preBuilder['where']
                    . $this->_preBuilder['group']
                    . $this->_preBuilder['having']
                    . $this->_preBuilder['order']
                    . $limit . $offset;
            case Db::UPDATE:
                break;
            default: return null;
        }
    }
}

?>