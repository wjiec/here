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
use Here\Lib\Exceptions\OverrideError;


/**
 * Class IoFilterBase
 * @package Here\lib\io\filter\validator
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
     * @param string $name
     * @param mixed $value
     * @param bool $override
     * @throws OverrideError
     */
    final protected function set_option($name, $value, $override = true) {
        Assert::String($name);
        if ($override === false && array_key_exists($name, $this->_options['options'])) {
            throw new OverrideError("cannot override filter options `{$name}`");
        }
        $this->_options['options'][$name] = $value;
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
