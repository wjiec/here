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
        return $conn->close();
    }
}

?>