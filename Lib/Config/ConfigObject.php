<?php
/**
 * ConfigObject.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config;


/**
 * Class ConfigObject
 * @package Here\Lib\Config
 */
final class ConfigObject implements ConfigObjectInterface, \IteratorAggregate {
    /**
     * @var array
     */
    private $_config;

    /**
     * ConfigObject constructor.
     * @param array|null $init_config
     */
    final public function __construct(?array $init_config = null) {
        $this->_config = $init_config;
    }

    /**
     * @param string $key
     * @param null $default
     * @return array|mixed|null
     */
    final public function get_item(string $key, $default = null) {
        $current_position = $this->_config;
        foreach (explode('.', $key) as $segment) {
            if (isset($current_position[$segment])) {
                $current_position = $current_position[$segment];
            } else {
                return $default;
            }
        }
        return $current_position;
    }

    /**
     * @param int $index  Assignment is -1 representation of random allocation
     * @return array|null
     */
    final public function get_cache(int $index = -1): ?array {
        $max_length = count($this->get_item(ConfigItemType::CFG_CACHE));
        if ($index < 0 || $index >= $max_length) {
            $index = random_int(0, $max_length - 1);
        }

        return $this->get_item(ConfigItemType::CFG_CACHE)[$index];
    }

    /**
     * @return array
     */
    final public function to_array(): array {
        return $this->_config;
    }

    /**
     * @return \Traversable|void
     */
    final public function getIterator() {
        return new \ArrayIterator($this->_config);
    }
}
