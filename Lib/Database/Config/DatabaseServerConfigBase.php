<?php
/**
 * DatabaseServerConfigBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Config;
use Here\Lib\Utils\Toolkit\StringToolkit;


/**
 * Class DatabaseServerConfigBase
 * @package Here\Lib\Database\Config
 */
abstract class DatabaseServerConfigBase implements DatabaseServerConfigInterface {
    /**
     * @var array
     */
    protected $_database_config;

    /**
     * DatabaseServerConfigBase constructor.
     * @param array $database_config
     */
    final public function __construct(array $database_config) {
        $this->_database_config = $database_config;
    }

    /**
     * @return string
     */
    final public function get_dsn(): string {
        return StringToolkit::format('%s://%s:%s@%s:%s/%s#%s',
            $this->get_driver(),
            $this->get_username(), $this->get_password(),
            $this->get_host(), $this->get_port(),
            $this->get_database(),
            $this->get_charset()
        );
    }

    /**
     * @return string
     */
    public function get_driver(): string {
        return $this->_database_config['driver'] ?? '';
    }

    /**
     * @return string
     */
    public function get_name(): string {
        return $this->_database_config['name'] ?? '';
    }

    /**
     * @return string
     */
    public function get_host(): string {
        return $this->_database_config['host'] ?? '';
    }

    /**
     * @return int
     */
    public function get_port(): int {
        return $this->_database_config['port'] ?? -1;
    }

    /**
     * @return string
     */
    public function get_username(): string {
        return $this->_database_config['username'] ?? '';
    }

    /**
     * @return string
     */
    public function get_password(): string {
        return $this->_database_config['password'] ?? '';
    }

    /**
     * @return string
     */
    public function get_database(): string {
        return $this->_database_config['database'] ?? '';
    }

    /**
     * @return string
     */
    public function get_charset(): string {
        return $this->_database_config['charset'] ?? 'utf8';
    }

    /**
     * @return array
     */
    public function get_params(): array {
        return $this->_database_config['params'] ?? array();
    }
}
