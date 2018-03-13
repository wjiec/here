<?php
/**
 * IoFilterBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter;
use Here\Lib\Assert;


/**
 * Class IoFilterBase
 * @package Here\Lib\io\filter\validator
 */
abstract class IoFilterBase implements IoFilterInterface {
    /**
     * @var array
     */
    private $_options = array(
        'options' => array(),
        'flags' => 0
    );

    /**
     * @var array
     */
    private $_private_options = array();

    /**
     * @param string $name
     * @param mixed $value
     */
    final public function __set($name, $value) {
        Assert::String($name);

        if ($name[0] === '_') {
            $this->_private_options[$name] = $value;
        } else {
            $this->_options['options'][$name] = $value;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    final public function __get($name) {
        Assert::String($name);

        if ($name[0] === '_') {
            if (array_key_exists($name, $this->_private_options)) {
                return $this->_private_options[$name];
            } else {
                return null;
            }
        }

        if (array_key_exists($name, $this->_options)) {
            return $this->_options[$name];
        }
        return null;
    }

    /**
     * @param int $flag
     */
    final protected function add_flag($flag) {
        Assert::Integer($flag);
        $this->_options['flags'] |= $flag;
    }

    /**
     * @return array
     */
    final protected function get_options() {
        return $this->_options;
    }
}
