<?php
/**
 * @author ShadowMan
 * @package here::Db
 */
// TODO Anonymous Query
class Db {
    # Keyword: SELECT
    const SELECT = 'SELECT';

    # Keyword: UPDATE
    const UPDATE = 'UPDATE';

    #Keyword: DELETE
    const DELETE = 'DELETE';

    #Keyword: INSERT
    const INSERT = 'INSERT';

    # INNER JOIN
    const INNER_JOIN = 'INNER JOIN';

    # LEFT JOIN
    const LEFT_JOIN = 'LEFT JOIN';

    # RIGHT JOIN
    const RIGHT_JOIN = 'RIGHT JOIN';

    # Sort DESC
    const DESC = 'DESC';

    # Sort ASC
    const ASC = 'ASC';

    # Operator =
    const OP_EQUAL = '=';

    # Operator !=
    const OP_NOT_EQUAL = '!=';

    # Operator >
    const OP_GT = '>';

    # Operator <
    const OP_LT = '<';

    # Operator >=
    const OP_GT_EQUAL = '>=';

    # Operator
    const OP_LT_EQUAL = '<=';

    # Relationship: AND
    const RS_AND = 'AND';

    # Relationship: OR
    const RS_OR = 'OR';

    # Factory Mode: Auto connect
    const CONNECT = 'CONNECT';

    const DATA_DEFAULT = '$_$DEFAULT$_$';

    const DATA_NULL    = '$_$NULL$_$';

    /**
     * table prefix
     * @var string
     */
    private $_prefix = null;

    /**
     * database config
     * @var Config
     */
    private static $_config = null;

    /**
     * Mysqli instance
     * @var Widget_Db_Mysql
     */
    private $_instance = null;

    /**
     * Query result
     * @var array
     */
    private $_result = null;

    private $_index = 0;

    private $_status = null;

    public function __construct($prefix = null) {
        $this->_prefix = ($prefix) ? $prefix : (self::$_config && self::$_config->prefix) ? self::$_config->prefix : null;
        $this->_instance = new Widget_Db_Mysql();
        if (!$this->_prefix) {
            if (self::$_config == null) {
                throw new Exception('database server not defined', 9);
            }
            throw new Exception('table prefix not defined', 9);
        }

        if (!(self::$_config instanceof Config)) {
            throw new Exception('database config invalid', 8);
        }
    }

    public static function factory($connect = null) {
        $db = new Db();
        if ($connect) {
            $db->connect();
        }

        return $db;
    }

    /**
     * add server
     * @param array $config
     */
    public static function server($config) {
        self::$_config = Config::factory($config);
    }

    /**
     * return Db Server Config
     * @return Config
     */
    public static function getConfig() {
        return self::$_config;
    }

    /**
     * get server info(version)
     * @return string
     */
    public function getServerInfo() {
        return $this->_instance->serverInfo();
    }

    public function setCharsetUTF8() {
        $this->_instance->setCharset('utf8');
    }

    /**
     * Pre Builder
     * @return Widget_Db_Query
     */
    public function builder() {
        return new Widget_Db_Query($this->_prefix, $this->_instance);
    }

    /**
     * query method
     * @return Widget_Db_Query
     */
    public function select() {
        $args = func_get_args();
        return $this->builder()->select(($args && !empty($args)) ? $args : null);
    }

    /**
     * query method
     * @param string $table
     * @return Widget_Db_Query
     */
    public function update($table) {
        return $this->builder()->update($table);
    }

    /**
     * query method
     * @param string $table
     * @return Widget_Db_Query
     */
    public function delete($table) {
        return $this->builder()->delete($table);
    }

    /**
     * query method
     * @param string $table
     * @return Widget_Db_Query
     */
    public function insert($table) {
        return $this->builder()->insert($table);
    }

    /**
     * connect to server
     */
    private function connect() {
        $this->_instance->connect(self::$_config);
    }

    /**
     * query
     * @param mixed $query
     * @param string $operator
     * @return NULL|Config
     */
    public function query($query, $operator = Db::SELECT) {
        if ($query instanceof Widget_Db_Query) {
            $operator = $query->getAction();
        } else if (!is_string($query)) {
            return null;
        }

        if ($operator == null) {
            throw new Exception('Query action not set', 'D:2');
        }

        $this->connect();
        $result = $this->_instance->query($query);
        if ($result instanceof mysqli_result) {
            if (is_array($this->_result)) {
                array_splice($this->_result, 0, count($this->_result));
            }
            while ($row = $result->fetch_assoc()) {
                $this->_result[] = $row;
            }
            $result->free();
            $this->_index = 0;
        }

        

        switch($operator) {
            case Db::UPDATE:
            case Db::DELETE:
                return $this->_instance->affectedRows();
            case Db::INSERT:
                return $this->_instance->lastInsertId();
            case Db::SELECT:
            default:
                return $this->_result;
        }
    }

    public function fetchAssoc($keys = null) {
        if (is_array($keys)) {
            $values = array();

            foreach ($keys as $key) {
                $values[] = isset($this->_result[$this->_index][$key]) ? $this->_result[$this->_index][$key] : null;
            }
            return $values;
        } else if (is_string($keys)) {
            return isset($this->_result[$this->_index][$keys]) ? $this->_result[$this->_index][$keys] : null;
        } else {
            return $this->_result[$this->_index];
        }
    }

    public function fetchAll() {
        return $this->_result;
    }

    public function resetResult($index = 0) {
        $this->_index = $index;
    }
}

?>