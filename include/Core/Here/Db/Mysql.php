<?php
/**
 * @author ShadowMan
 */
class Db_Mysql implements Widget_Abstract_Db {
    /**
     * @var mysqli
     */
    private $_link = null;

    private $_connected = false;

    public function isAvailable() {
        return class_exists('mysqli') ? true : function_exists('mysqli_connect') ? true : false;
    }

    public function serverInfo() {
        return $this->_link->server_info;
    }

    public function connect(Config $config) {
        $this->_link = @new mysqli($config->host, $config->user, $config->password, $config->database, $config->port);

        if ($this->_link->connect_errno) {
            throw new Exception($this->_link->connect_error, $this->_link->connect_errno);
        }
    }
    

    public function fetchObject($resource) {
    }

    public function lastInsertId() {
        return $this->_link->insert_id;
    }

    public function ping() {
        return $this->_link->ping();
    }

    /**
     * (non-PHPdoc)
     * @see Widget_Db::escapeKey()
     * @param string $string
     * @return string
     */
    public function escapeKey($string) {
        $length = strlen($string);
        $result = '`';

        for ($index = 0; $index < $length; ++$index) {
            $ch = $string[$index];
            if (ctype_alnum($ch)) {
                $result .= $ch;
            } else if ($ch == '.') {
                $result .= '`.`';
            }
        }
        $result .= '`';
        return $result;
    }

    public function escapeValue($string) {
        return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $string) . '\'';
    }

    public function query($query) {
        $query = trim(($query instanceof Db_Query) ? $query->__toString() : $query);
        $result = null;

        if (strlen($query) && !($result = $this->_link->query($query))) {
            if ($this->_link->errno != 0) {
                throw new Exception($this->_link->error, $this->_link->errno);
            }
        }
        return $result;
    }

    public function affectedRows() {
        return $this->_link->affected_rows;
    }

    /**
     * (non-PHPdoc)
     * @see Widget_Db::fetch()
     * @param $resource
     */
    public function fetch($resource) {
    }
}

?>