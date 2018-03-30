<?php
/**
 * CacheAdapterInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Adapter;


/**
 * Interface CacheAdapterInterface
 * @package Here\Lib\Cache\Adapter
 */
interface CacheAdapterInterface {
    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get_item(string $name, $default = null);

    /**
     * @param string $name
     * @param mixed $value
     * @param int $expired
     * @return mixed
     */
    public function set_item(string $name, $value, int $expired = 0);
}
