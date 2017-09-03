<?php
/**
 * ConfigBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Abstracts;
use Here\Lib\Assert;
use Here\Lib\Interfaces\ConfigInterface;


/**
 * Class ConfigBase
 * @package Here\Lib\Abstracts
 */
class ConfigBase implements ConfigInterface {
    /**
     * @var string
     */
    protected $_config_path;

    /**
     * @var array
     */
    private $_config;

    /**
     * ConfigBase constructor.
     */
    final public function __construct() {
        $this->_config_path = __FILE__;

        $ref = new \ReflectionClass(get_class($this));
        $default_properties = $ref->getDefaultProperties();
        foreach ($default_properties as $key => $val) {
            $this->_config[trim($key, '_')] = $val;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    final public function __get($name) {
        Assert::String($name);
        if (array_key_exists($name, $this->_config)) {
            return $this->_config[$name];
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    final public function __set($name, $value) {
    }

    /**
     * @see ConfigInterface::save()
     */
    final public function save() {
    }
}