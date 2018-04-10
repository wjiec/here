<?php
/**
 * DatabaseHelper.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database;
use Here\Lib\Database\Config\DatabaseServerConfigInterface;


/**
 * Class DatabaseHelper
 * @package Here\Lib\Database
 */
final class DatabaseHelper {
    /**
     * @var DatabaseServerConfigInterface[]
     */
    private static $_servers = array();

    /**
     * @param DatabaseServerConfigInterface $server
     */
    final public static function add_server(DatabaseServerConfigInterface $server): void {

    }
}
