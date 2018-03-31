<?php
/**
 * CacheServerConfigBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config;


/**
 * Class CacheServerConfigBase
 * @package Here\Lib\Cache
 */
abstract class CacheServerConfigBase implements CacheServerConfigInterface {
    /**
     * @var array
     */
    private $_config;

    /**
     * CacheServerConfigBase constructor.
     * @param array $config
     */
    final public function __construct(array $config) {
        $this->_config = $config;
    }

    /**
     * @param UnknownCacheServerConfig $config
     * @return CacheServerConfigBase
     */
    final public static function from(UnknownCacheServerConfig $config): self {
        return new static($config->get_origin());
    }

    /**
     * @return string
     */
    final public function get_name(): string {
        return $this->_config['name']
            ?? $this->_config['driver'];
    }

    /**
     * @return string
     */
    final public function get_host(): string {
        return $this->_config['host'];
    }

    /**
     * @param int $default_port
     * @return int
     */
    final public function get_port(int $default_port): int {
        return $this->_config['port'] ?? $default_port;
    }

    /**
     * @return null|string
     */
    final public function get_username(): ?string {
        return $this->_config['username'] ?? null;
    }

    /**
     * @return null|string
     */
    final public function get_password(): ?string {
        return $this->_config['password'] ?? null;
    }

    /**
     * @return string
     */
    final public function get_driver(): string {
        return $this->_config['driver'];
    }

    /**
     * @return array
     */
    final private function get_origin(): array {
        return $this->_config;
    }
}
