<?php
/**
 * ExceptionLevel.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Abstracts;
use Here\Lib\Assert;


/**
 * Class ExceptionLevel
 * @package Here\Lib\Abstracts
 */
abstract class ExceptionLevelBase {
    /**
     * @var int
     */
    protected $_level;

    /**
     * @var string
     */
    protected $_name;

    /**
     * ExceptionLevel constructor.
     */
    final public function __construct() {
        Assert::String($this->_name());
        Assert::Integer($this->_level());
        Assert::True(abs($this->_level()) < 100);

        $this->_name = $this->_name();
        $this->_level = abs($this->_level());
    }

    /**
     * @param string $name
     * @return int|string|null
     */
    final public function __get($name) {
        switch ($name) {
            case 'name': return $this->_name;
            case 'level': return $this->_level;
            default: return null;
        }
    }

    /**
     * error severity for exception level
     *
     * @return int
     */
    abstract protected function _level();

    /**
     * exception level name
     *
     * @return string
     */
    abstract protected function _name();
}
