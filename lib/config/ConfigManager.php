<?php
/**
 * ConfigManager.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config;
use Here\Lib\Assert;
use Here\Lib\Autoloader;
use Here\Lib\Abstracts\ConfigBase;
use Here\Lib\Exceptions\ConfigNotFound;


/**
 * Class ConfigManager
 * @package Here\Lib\Config
 */
class ConfigManager {
    /**
     * @var array
     */
    private static $_config_pool = array();

    /**
     * @param string $conf_name
     * @throws ConfigNotFound
     * @return ConfigBase
     */
    final public static function get_conf($conf_name) {
        Assert::String($conf_name);

        $conf_name = ucfirst(strtolower($conf_name));
        if (array_key_exists($conf_name, self::$_config_pool)) {
            return self::$_config_pool[$conf_name];
        }

        $conf_class = "Here\\Config\\{$conf_name}Config";
        if (!Autoloader::class_exists($conf_class)) {
            throw new ConfigNotFound("cannot resolve {$conf_name}");
        }

        $config = new $conf_class();
        self::$_config_pool[$conf_name] = $config;
        return $config;
    }
}
