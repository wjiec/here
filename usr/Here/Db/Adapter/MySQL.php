<?php
/**
 * Here Db Adapter MySQL
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Db_Adapter_MySQL extends Here_Abstracts_Adapter {
    /**
     * check mysql avaliable
     *
     * @see \SDB\Abstracts\Adapter::available()
     */
    public function available() {
        return class_exists('mysqli') ? true : false;
    }

    /**
     * connect to database
     *
     * @param string $host
     * @param string|int $port
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $charset
     * @return boolean connect state
     * @throws \Exception connect error information
     */
    public function connect($host, $port, $user, $password, $database, $charset = 'utf8') {
        if ($this->_connect_flag == false && $this->_instance == null) {
            $this->_instance = @new \mysqli($host, $user, $password, $database, $port);

            if ($this->_instance->connect_errno) {
                throw new \Exception("SDB: MySQL: {$this->_instance->connect_errno}: {$this->_instance->connect_error}", 1996);
            }
            if ($charset != null) {
                $this->_instance->set_charset($charset);
            }

            $this->_connect_flag = true;
        }
    }

    /**
     * return database information
     */
    public function server_info() {
        if ($this->_connect_flag == false && $this->_instance == null) {
            throw new \Exception('SDB: Required connect first', 1996);
        }

        return $this->_instance->server_info;
    }

    /**
     * return last insert row id
     */
    public function last_insert_id() {
        return $this->_instance->insert_id;
    }

    /**
     * return last query affected rows
     */
    public function affected_rows() {
        return $this->_instance->affected_rows;
    }

    /**
     * filter table name
     *
     * @see \SDB\Abstracts\Adapter::tableFilter()
     */
    public function table_filter($table) {
        if (strchr($table, '.') === strrchr($table, '.')) {
            return '`' . ((strpos($table, 'table.') === 0) ? substr_replace($table, $this->_table_prefix, 0, 6) : $table) . '`';
        } else {
            $table = trim(((strpos($table, 'table.') === 0) ? substr_replace($table, $this->_table_prefix, 0, 6) : $table) . '`', '`');
            return $this->quote_key($table);
        }
    }

    /**
     * based preBuilder generate SELECT syntax
     *
     * @param array $pre_builder
     * @return string
     */
    public function parse_select($pre_builder, $table) {
        $sql = 'SELECT ';
        $sql .= implode(', ', $this->parse_field($pre_builder['fields']));
        $sql .= ' FROM ' . $table;

        # JOIN
        if (!empty($pre_builder['join'])) {
            foreach ($pre_builder['join'] as $row) {
                $sql .= " {$row['references']} ( " . implode(', ', $row['tables']) . " )";
            }
        }

        # ON
        if (!empty($pre_builder['on'])) {
            $sql .= " ON ( " . self::parse_ON($pre_builder['on']) . " )";
        }

        # WHERE
        if (!empty($pre_builder['where'])) {
            $sql .= ' WHERE ';
            foreach ($pre_builder['where'] as $row) {
                $sql .= "{$row['lval']} {$row['operator']} {$row['rval']} {$row['conjunction']} ";
            }

            if ($sql[strlen($sql) - 2] == 'R') {
                $sql = substr($sql, 0, strlen($sql) - 4);
            } else {
                $sql = substr($sql, 0, strlen($sql) - 5);
            }
        }

        # GROUP
        if (!empty($pre_builder['group'])) {
            $sql .= ' GROUP BY ';
            foreach ($pre_builder['group'] as $row) {
                $sql .= "{$row['field']} {$row['sort']}, ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
        }

        # HAVING
        if (!empty($pre_builder['having'])) {
            $sql .= ' HAVING ';
            foreach ($pre_builder['having'] as $row) {
                $sql .= "{$row['lval']} {$row['operator']} {$row['rval']} {$row['conjunction']} ";
            }

            if ($sql[strlen($sql) - 2] == 'R') { # $conjunction = OR
                $sql = substr($sql, 0, strlen($sql) - 4);
            } else { # $conjunction = AND
                $sql = substr($sql, 0, strlen($sql) - 5);
            }
        }

        # ORDER
        if (!empty($pre_builder['order'])) {
            $sql .= ' ORDER BY ';
            foreach ($pre_builder['order'] as $row) {
                $sql .= "{$row['field']} {$row['sort']}, ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
        }

        # LIMIT
        if ($pre_builder['limit'] != null) {
            $sql .= " LIMIT {$pre_builder['limit']}";
        }

        # OFFSET
        if ($pre_builder['offset'] != null) {
            $sql .= " OFFSET {$pre_builder['offset']}";
        }

        return $sql;
    }

    /**
     * based preBuilder generate UPDATE syntax
     *
     * @param string $pre_builder
     * @return string
     */
    public function parse_update($pre_builder, $table) {
        $sql = 'UPDATE ';
        $sql .= $table;

        $sql .= ' SET ';
        foreach ($pre_builder['set'] as $key => $value) {
            $sql .= "{$key} = {$value}, ";
        }
        $sql = substr($sql, 0, strlen($sql) - 2);

        if (!empty($pre_builder['where'])) {
            $sql .= ' WHERE ';
            foreach ($pre_builder['where'] as $row) {
                $sql .= "{$row['lval']} {$row['operator']} {$row['rval']} {$row['conjunction']} ";
            }

            if ($sql[strlen($sql) - 2] == 'R') {
                $sql = substr($sql, 0, strlen($sql) - 4);
            } else {
                $sql = substr($sql, 0, strlen($sql) - 5);
            }
        }

        if (!empty($pre_builder['order'])) {
            $sql .= ' ORDER BY ';
            foreach ($pre_builder['order'] as $row) {
                $sql .= "{$row['field']} {$row['sort']}, ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
        }

        if ($pre_builder['limit'] != null) {
            $sql .= " LIMIT {$pre_builder['limit']}";
        }

        return $sql;
    }

    /**
     * based preBuilder generate INSERT syntax
     *
     * @param string $pre_builder
     * @return string
     */
    public function parse_insert($pre_builder, $table) {
        $sql = 'INSERT INTO ';
        $sql .= $table;

        if (!empty($pre_builder['rows']['keys'])) {
            $sql .= ' ( ' . implode(', ', array_values($pre_builder['rows']['keys'])) . ' ) ';
        }

        if ($pre_builder['insertSelect'] instanceof Here_Db_Query) {
            $sql .= call_user_func(array($pre_builder['insertSelect'], '__toString'));

            return $sql;
        }

        $sql .= 'VALUES ';
        if (empty($pre_builder['rows']['values'])) {
            throw new \Exception('SDB: MySQL: Empty Row(s)', 1996);
        } else {
            foreach ($pre_builder['rows']['values'] as $row) {
                $sql .= '( ' . implode(', ', array_values($row)) . ' ), ';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 2); // Remove unnecessary ', '

        return $sql;
    }

    /**
     * based preBuilder generate DELETE syntax
     *
     * @param string $pre_builder
     * @return string
     */
    public function parse_delete($pre_builder, $table) {
        $sql = 'DELETE FROM ';
        $sql .= is_array($table) ? implode(', ', $table) : $table;

        if (is_array($table)) {
            if (strlen($pre_builder['using']) === 0) {
                throw new \Exception('SDB: MySQL: syntax error for multi-table delete', 1996);
            } else {
                $sql .= ' USING ' . $pre_builder['using'];
            }
        }

        if (!empty($pre_builder['join'])) {
            foreach ($pre_builder['join'] as $row) {
                $sql .= " {$row['references']} ( " . implode(', ', $row['tables']) . " )";
            }
        }

        if (!empty($pre_builder['on'])) {
            $sql .= " ON ( " . self::parse_ON($pre_builder['on']) . " )";
        }

        if (!empty($pre_builder['where'])) {
            $sql .= ' WHERE ';
            foreach ($pre_builder['where'] as $row) {
                $sql .= "{$row['lval']} {$row['operator']} {$row['rval']} {$row['conjunction']} ";
            }

            if ($sql[strlen($sql) - 2] == 'R') {
                $sql = substr($sql, 0, strlen($sql) - 4);
            } else {
                $sql = substr($sql, 0, strlen($sql) - 5);
            }
        }

        if (!empty($pre_builder['order'])) {
            $sql .= ' ORDER BY ';
            foreach ($pre_builder['order'] as $row) {
                $sql .= "{$row['field']} {$row['sort']}, ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
        }

        if ($pre_builder['limit'] != null) {
            $sql .= " LIMIT {$pre_builder['limit']}";
        }

        return $sql;
    }

    /**
     * quoted identifiers
     *
     * @param string $string
     */
    public function quote_key($string) {
        if (!is_string($string)) {
            throw new \Exception('SDB: MySQL: the key must string', 1996);
        }

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

        if ($this->brackets_matcher($result)) {
            return trim($result, '`');
        }

        return $result;
    }

    /**
     * quoted identifiers
     *
     * @param string $string
     */
    public function quote_value($string) {
        if (!is_string($string)) {
            $string = strval($string);
        }
        return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $string) . '\'';
    }

    /**
     * execute query
     *
     * @param SDB\Query|string $query
     */
    public function query($query) {
        if (is_string($query) && strlen($query)) {
            $result = $this->_instance->query($query);

            if ($this->_instance->errno !== 0) {
                throw new \Exception("SDB: MySQL: {$this->_instance->errno}: {$this->_instance->error}", 1996);
            }

            if ($result instanceof \mysqli_result) {
                if (is_array($this->_result)) {
                    array_splice($this->_result, 0, count($this->_result));
                }

                for ($row = $result->fetch_assoc(); $row;) {
                    $this->_result[] = $row;
                }

                $result->free();
            }
        }

        return true;
    }

    /**
     * fetch last query data
     *
     * @param array $keys
     * @return array
     */
    public function fetch_assoc($keys = null) {
        if (is_array($keys)) {
            $values = array();

            foreach ($keys as $key) {
                $values[$key] = isset($this->_result[$this->_result_current_index][$key]) ? $this->_result[$this->_result_current_index][$key] : null;
            }
            $this->_result_current_index += 1;
            return $values;
        } else if (is_string($keys)) {
            return isset($this->_result[$this->_result_current_index][$keys]) ? $this->_result[$this->_result_current_index++][$keys] : null;
        } else {
            return $this->_result[$this->_result_current_index++];
        }
    }

    /**
     * fetch last query data
     *
     * @return array
     */
    public function fetch_all() {
        return $this->_result;
    }

    private function brackets_matcher($string) {
        $stack = array();
        $push_flags = false;

        $string = str_split($string);
        foreach ($string as $ch) {
            if (in_array($ch, array('(', '[', '{'))) {
                $push_flags = true;
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

        return empty($stack) && $push_flags;
    }

    private function parse_field(array $fields) {
        foreach ($fields as &$field) {
            if (is_array($field)) {
                $field = $field[0] . " AS " . $field[1];
            }
        }

        return $fields;
    }

    private function parse_ON($references) {
        $on = "";

        foreach ($references as $row) {
            $on .= "{$row['lval']['table']}.{$row['lval']['field']} {$row['operator']} {$row['rval']['table']}.{$row['rval']['field']} {$row['conjunction']} ";
        }
        if ($on[strlen($on) - 2] == 'R') { // OR
            $on = substr($on, 0, strlen($on) - 4);
        } else {
            $on = substr($on, 0, strlen($on) - 5);
        }
        return $on;
    }
}
