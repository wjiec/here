<?php
/**
 * @author ShadowMan
 * @package Core.DB
 */
// TODO. Static Class ?
class DB {
    private $_pool;
    private $_rows;
    
    /**
     * MySQL Server Info 
     * @var array
     * @access private
     */
    private static $_server = [];
    
    public function __construct($user = null, $password = null, $database = null, $pref = null, $host = null, $port = 3306) {
        $this->_pool = [];
        $this->_rows = [];

        if (empty(self::$_server)) {
            throw new Exception('Please add MySql Server using DB::server', 0x1);
        }

        $conn = new mysqli(self::$_server['host'], self::$_server['user'], self::$_server['password'], self::$_server['database'], self::$_server['port']);
        if ($conn->connect_errno) {
            throw new Exception($conn->connect_error, $conn->connect_errno);
        }
        if (!$conn->ping()) {
            throw new Exception($conn->error);
        }
        $conn->set_charset('utf8');
    }
    /**
     * set MySQL Server info 
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $host
     * @param string $port
     */
    public static function server($host, $user, $password, $database, $port = 3306) {
        // func_get_args & get_defined_vars
        if (call_user_func_array('self::ping', get_defined_vars())) {
            self::$_server = array_merge(self::$_server, get_defined_vars());
        } else {
            // self::ping -> throw Exception
        }
    }
    /**
     * connect to Mysql Server Test 
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $host
     * @param number $port
     * @throws Exception
     * @return boolean
     */
    public static function ping($host = null, $user = null, $password = null, $database = null, $port = 3306) {
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

    public function insert(array $key, array $val) {
        if (count($key) != count($val)) {
            throw new Exception("");
        }
    }

    public function delete(array $key, array $val) {
    }

    public function update(array $key, array $val) {
        if (count($key) != count($val)) {
            throw new Exception("");
        }
    }

    public function select($sql) {
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