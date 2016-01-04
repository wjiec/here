<?php
/**
 * @author ShadowMan
 * @package Core.DB
 */
class DB {
    private $_pool;
    private $_data;
    
    /**
     * MySQL Server Info 
     * @var array
     * @access private
     */
    private static $__server = [];
    
    public function __construct($user = null, $password = null, $database = null, $pref = null, $host = null, $port = 3306) {
        $this->_pool = [];
        $this->_data = [];

        if (empty(self::$__server)) {
            throw new Exception('Please add MySql Server using DB::server');
        }

        $conn = new mysqli(self::$__server['host'], self::$__server['user'], self::$__server['password'], self::$__server['database'], self::$__server['port']);
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
            self::$__server = array_merge(self::$__server, get_defined_vars());
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