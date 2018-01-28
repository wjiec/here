<?php
/**
 * RedisAdapter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Adapter;


/**
 * Class RedisAdapter
 * @package Here\Lib\Cache\Adapter
 */
final class RedisAdapter extends CacheAdapterBase {
    /**
     * @var array
     */
    private $_server;

    /**
     * RedisAdapter constructor.
     * @param string $host
     * @param int $port
     * @param string|null $username
     * @param string|null $password
     */
    final public function __construct(string $host, int $port, ?string $username = null, ?string $password = null) {
        $this->_server = func_get_args();
        var_dump($this);
    }

    /**
     * @param string $name
     * @return mixed|void
     */
    public function get_item(string $name) {
        // TODO: Implement get_item() method.
    }

    /**
     * @param string $name
     * @param $value
     * @param int $expired
     * @return mixed|void
     */
    public function set_item(string $name, $value, $expired = 0) {
        // TODO: Implement set_item() method.
    }
}
