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

    private $_table = null;

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
            'limit' => null,
            'offset' => null,
            'where' => null,
            'order' => null
        ];
    }

    public function getAction() {
        return ($this->_action) ? $this->_action : null;
    }

    public function trim($str) {
        
    }

    public function rows(array $rows) {
        foreach ($rows as $key => $val) {
            $this->_preBuilder['rows'][$key] = $this->_instance->escapeValue($val);
        }
        return $this;
    }

    public function select() {
        $this->_action = Db::SELECT;

        $args = func_num_args();
        foreach ($args as $val) {
            $this->_preBuilder['fields'][] = $val;
        }
        return $this;
    }

    public function from($table) {
        $this->_table = $table;
        return $this;
    }

    public function update($table) {
        $this->_action = Db::UPDATE;
        $this->_table  = $table;
        return $this;
    }

    public function delete($table) {
        $this->_action = Db::DELETE;
        $this->_table  = $table;
        return $this;
    }

    public function insert($table) {
        $this->_action = Db::INSERT;
        $this->_table  = $table;
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

    public function order($by, $sort = Db::DESC) {
        if (!is_string($by)) {
            return $this;
        }
        $this->_preBuilder['order'] = in_array($sort, [ Db::DESC, Db::ASC ]) ? $sort : null;
        $this->_preBuilder['order'] = ($this->_preBuilder['order']) ? " ORDER BY {$by} {$sort} " : null;
        return $this;
    }

    public function __toString() {
        switch ($this->_action) {
            case Db::DELETE:
                break;
            case Db::INSERT:
                return 'INSERT INTO ' . $this->_table
                    . '( ' . implode(', ', array_keys($this->_preBuilder['rows'])) . ' )'
                    . ' VALUE '
                    . '( ' . implode(',', array_values($this->_preBuilder['rows'])) . ' )'
                    . $this->_preBuilder['limit'];
            case Db::SELECT:
                break;
            case Db::UPDATE:
                break;
            default: return null;
        }
    }
}

?>