<?php
/**
 * @author ShadowMan
 * @package Here.Interface.Db
 */
interface Widget_Abstract_Db {
    public function isAvailable();

    public function ping();

    public function serverInfo();

    public function connect(Config $config);

    public function escapeKey($string);

    public function escapeValue($string);

    public function query($query);

    public function affectedRows();

    public function lastInsertId();

    public function fetch($resource);

    public function fetchObject($resource);
}

?>