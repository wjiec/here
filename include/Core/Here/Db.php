<?php
/**
 * @author ShadowMan
 * @package here::Db
 */
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
    const RIGHT_JOIN = 'RIGHT_JOIN';

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

    # Factory Mode: Connect By Hand
    const NORMAL  = 'NORMAL';

    /**
     * table prefix
     * @var string
     */
    private $_prefix = null;

    /**
     * database config
     * @var Config
     */
    private static $_config;

    /**
     * Mysqli Instance
     * @var Db_Mysql
     */
    private $_instance = null;

    /**
     * Query result
     * @var array
     */
    private $_result = null;

    private $_status = null;

    public function __construct($prefix = null) {
        $this->_prefix = ($prefix) ? $prefix : (self::$_config->prefix) ? self::$_config->prefix : null;
        $this->_instance = new Db_Mysql();
        if (!$this->_prefix) {
            throw new Exception('Prefix not set', 0x9);
        }

        if (!(self::$_config instanceof Config)) {
            throw new Exception('Database config invalid', 0x8);
        }
    }

    public static function factory($while = Db::NORMAL) {
        $db = new Db();
        switch ($while) {
            case Db::CONNECT:
                $db->connect();
                $db->_status = Db::CONNECT;
                break;
            case Db::NORMAL:
            default: break;
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

    /**
     * Pre Builder
     * @return Db_Query
     */
    public function builder() {
        return new Db_Query($this->_prefix, $this->_instance);
    }

    /**
     * query method
     * @return Db_Query
     */
    public function select() {
        $args = func_get_args();
        return $this->builder()->select(($args && !empty($args)) ? $args : null);
    }

    /**
     * query method
     * @param string $table
     * @return Db_Query
     */
    public function update($table) {
        return $this->builder()->update($table);
    }

    /**
     * query method
     * @param string $table
     * @return Db_Query
     */
    public function delete($table) {
        return $this->builder()->delete($table);
    }

    /**
     * query method
     * @param string $table
     * @return Db_Query
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
        if ($query instanceof Db_Query) {
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
            while ($row = $result->fetch_assoc()) {
                $this->_result[] = $row;
            }
            $result->free();
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

    public function fetchAssoc() {
        return $this->_result;
    }
}

?>