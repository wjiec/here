<?php
/**
 * @author ShadowMan
 */
class Widget_Db_Mysql implements Interface_Db {
    /**
     * @var mysqli
     */
    private $_link = null;

    private $_connected = false;

    private $_charset = null;

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

        if ($this->_charset != null) {
            $this->_link->set_charset($this->_charset);
        }
    }

    public function setCharset($charset) {
        $this->_charset = $charset;
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
            if (ctype_alnum($ch) || in_array($ch, array('_', '(', ')', '`'))) {
                $result .= $ch;
            } else if ($ch == '.') {
                $result .= '`.`';
            }
        }
        $result .= '`';

        if ($this->bracketsMatch($result)) {
            return trim($result, '`');
        }

        return $result;
    }

    public function escapeValue($string) {
        if (!is_string($string)) {
            $string = strval($string);
        }
        return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $string) . '\'';
    }

    public function query($query) {
        $query = trim(($query instanceof Widget_Db_Query) ? $query->__toString() : $query);
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

    private function bracketsMatch($string) {
        $stack = array();
        $pushFlags = false;

        $string = str_split($string);
        foreach ($string as $ch) {
            if (in_array($ch, array('(', '[', '{'))) {
                $pushFlags = true;
                $stack[] = $ch;
            } else if (in_array($ch, array(')', ']', '}'))) {
                if ((end($stack) == '(' && $ch == ')') ||
                    (end($stack) == '[' && $ch == ']') ||
                    (end($stack) == '{' && $ch == '}')) {
                    array_pop($stack);
                } else {
                    return false;
                }
            }
        }

        return empty($stack) && $pushFlags;
    }
}

?>