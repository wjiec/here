<?php
/**
 * @author ShadowMan
 */
class Db_Mysql implements Widget_Db {
    /**
     * @var mysqli
     */
    private $_link = null;

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
    }

    public function ping() {
    }

    public function escapeKey($string) {
        return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $string) . '\'';
    }

    public function escapeValue($string) {
        return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $string) . '\'';
    }

    public function query($query) {
        if (!($result = $this->_link->query($query instanceof Db_Query ? $query->__toString() : $query))) {
            throw new Exception($this->_link->error, $this->_link->errno);
        }
        return $result;
    }

    public function affectedRows() {
    }

    public function fetch($resource) {
    }
}

?>