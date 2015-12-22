<?php
/**
 * @author ShadowMan
 * @package Core.DB
 */
class DB {
    public function __construct() {
    }

    public static function connectTest($user, $password, $database, $host, $port = 3306) {
        $conn = @new mysqli($host, $user, $password, $database, $port);

        if ($conn->connect_errno) {
            throw new Exception($conn->connect_error, $conn->connect_errno);
        }
        if (!$conn->ping()) {
            throw new Exception($conn->error);
        }
        return $conn->close();
    }

    public static function initTable($user, $password, $database, $pref, $host, $port = 3306) {
        
    }

    public static function addUser($username, $password, $email) {
        
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
}

?>