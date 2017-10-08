<?php
/**
 * MetaItem.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta;
use Here\Lib\Router\Collector\Method\Meta\Syntax\Result\MetaParseResultInterface;


/**
 * Class MetaItem
 * @package Here\Lib\Router\Collector\Meta
 */
class MetaItem {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_value;

    /**
     * MetaItem constructor.
     * @param string $name
     * @param string $value
     */
    final public function __construct($name, $value) {
        $this->_name = $name;
        $this->_value = $value;
    }

    /**
     * @return string
     */
    final public function get_name() {
        return $this->_name;
    }

    /**
     * @return string
     */
    final public function get_value() {
        return $this->_value;
    }
}
