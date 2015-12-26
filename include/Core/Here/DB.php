<?php
/**
 * @author ShadowMan
 * @package Core.DB
 */
class DB {
    private $_pool;
    private $_data;
    
    public function __construct($user, $password, $database, $pref, $host, $port = 3306) {
        $this->_pool = [];
        $this->_data = [];
        
        $conn = new mysqli($host, $user, $password, $database, $port);
        if ($conn->connect_errno) {
            throw new Exception($conn->connect_error, $conn->connect_errno);
        }
        if (!$conn->ping()) {
            throw new Exception($conn->error);
        }
        $conn->set_charset('utf8');
        $this->_pool[] = $conn;
    }

    public static function ping($user, $password, $database, $host, $port = 3306) {
        $conn = @new mysqli($host, $user, $password, $database, $port);

        if ($conn->connect_errno) {
            throw new Exception($conn->connect_error, $conn->connect_errno);
        }
        if (!$conn->ping()) {
            throw new Exception($conn->error);
        }
        return $conn->close();
    }

    public function query($sql) {
        
    }

    public function insert($sql) {
        
    }

    public function delete($sql) {
    
    }

    public function select($sql) {
        
    }

    public function update($sql) {
        
    }
    
    public function close() {
        if (empty($this->_pool)) {
            return true;
        }
        foreach ($this->_pool as $conn) {
            $conn->close();
        }
    }
    
    public function __destruct() {
        $this->close();
    }
}

?>