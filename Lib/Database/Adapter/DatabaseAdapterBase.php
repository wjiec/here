<?php
/**
 * DatabaseAdapterBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Adapter;


use Here\Lib\Database\Config\DatabaseServerConfigInterface;

/**
 * Class DatabaseAdapterBase
 *
 * @package Here\Lib\Database\Adapter
 */
abstract class DatabaseAdapterBase implements DatabaseAdapterInterface {
    /**
     * @var DatabaseServerConfigInterface
     */
    private $_server_config;

    /**
     * DatabaseAdapterBase constructor.
     * @param DatabaseServerConfigInterface $config
     */
    final public function __construct(DatabaseServerConfigInterface $config) {
        $this->_server_config = $config;
    }
}
