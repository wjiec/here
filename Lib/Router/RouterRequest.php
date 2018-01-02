<?php
/**
 * RouterRequest.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Stream\IStream\Client\Request;


/**
 * Class RouterRequest
 * @package Here\Lib\Router
 */
class RouterRequest extends Request {
    /**
     * @var array
     */
    private $_router_pairs = array();

    /**
     * @param string $name
     * @param string|null $value
     */
    final public function push_router_pair(string $name, ?string $value): void {
        if ($value) {
            $this->_router_pairs[$name] = $value;
        }
    }

    /**
     * @param string $name
     */
    final public function delete_router_pair(string $name): void {
        if (isset($this->_router_pairs[$name])) {
            unset($this->_router_pairs[$name]);
        }
    }

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public function get_pair_value(string $name, ?string $default = null): ?string {
        return $this->_router_pairs[$name] ?? $default;
    }
}
