<?php
/**
 * DatabaseAdapterInterface.php
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
 * Interface DatabaseAdapterInterface
 *
 * @package Here\Lib\Database\Adapter
 */
interface DatabaseAdapterInterface {
    /**
     * DatabaseAdapterInterface constructor.
     *
     * @param DatabaseServerConfigInterface $config
     */
    public function __construct(DatabaseServerConfigInterface $config);
}
