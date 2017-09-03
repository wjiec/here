<?php
/**
 * DatabaseConfig.phpig.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config;
use Here\Lib\Abstracts\ConfigBase;


/**
 * Class DatabaseConfig
 * @package Here\Config
 */
class DatabaseConfig extends ConfigBase {
    /**
     * @var string
     */
    private static $_host = 'localhost';

    /**
     * @var int
     */
    private static $_port = 3306;

    /**
     * @var string
     */
    private static $_username = 'root';

    /**
     * @var string
     */
    private static $_password = 'root';

    /**
     * @var string
     */
    private static $_database = 'here';

    /**
     * @var string
     */
    private static $_charset = 'utf8';
}
