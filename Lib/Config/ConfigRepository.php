<?php
/**
 * ConfigRepositoryory.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config;
use Lib\Config\ConfigObjectInterface;


/**
 * Class ConfigRepository
 * @package Here\Lib\Config
 */
class ConfigRepository {
    /**
     * @param string $config_path
     * @return ConfigObjectInterface
     */
    final public static function get_config(string $config_path): ConfigObjectInterface {
    }
}
