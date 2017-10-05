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


/**
 * Class MetaItem
 * @package Here\Lib\Router\Collector\Meta
 */
class MetaItem {
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;

    /**
     * MetaItem constructor.
     * @param string $name
     * @param string $value
     */
    final public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    final public function get_name() {
        return $this->name;
    }

    /**
     * @return string
     */
    final public function get_value() {
        return $this->value;
    }
}
