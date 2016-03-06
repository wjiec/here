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

    # Sort DESC
    const DESC = 'DESC';

    # Sort ASC
    const ASC = 'ASC';

    # Factory Mode
    const CONNECT = 'connect';
    const NORMAL  = 'normal';

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
     * @var Config
     */
    private $_result = null;

    public function __construct($prefix = null) {
        $this->_prefix = ($prefix) ? $prefix : (self::$_config->prefix) ? self::$_config->prefix : null;
        $this->_instance = new Db_Mysql();
        if (!$this->_prefix) {
            throw new Exception('Prefix not set');
        }

        if (!(self::$_config instanceof Config)) {
            throw new Exception('Database config invalid', 'D1');
        }
    }

    public static function factory($while = Db::NORMAL) {
        $db = new Db();
        switch ($while) {
            case Db::CONNECT: $db->connect(); break;
            case Db::NORMAL:
            default: break;
        }
        return $db;
    }

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

    public function select() {
        $args = func_get_args();
        return $this->builder()->select(($args && empty($args)) ? $args : array('*'));
    }

    public function update($table) {
        return $this->builder()->update($table);
    }

    public function delete($table) {
        return $this->builder()->delete($table);
    }

    public function insert($table) {
        return $this->builder()->insert($table);
    }

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
        $this->_result = $this->_instance->query($query);
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
}

?>