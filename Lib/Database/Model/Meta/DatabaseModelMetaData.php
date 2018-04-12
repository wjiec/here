<?php
/**
 * DatabaseModelMetaData.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model\Meta;


/**
 * Class DatabaseModelMetaData
 * @package Here\Config\Model\Meta
 */
final class DatabaseModelMetaData implements DatabaseModelMetaDataInterface {
    /**
     * @var array
     */
    private $_fields;

    /**
     * DatabaseModelMetaData constructor.
     */
    final public function __construct() {
        $this->_fields = array();
    }

    /**
     * @param string $name
     * @param string[] $properties
     */
    final public function add_field(string $name, array $properties): void {
        $this->_fields[$name] = $properties;
    }
}
