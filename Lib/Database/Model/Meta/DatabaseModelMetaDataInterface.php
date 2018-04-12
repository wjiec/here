<?php
/**
 * DatabaseModelMetaDataInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model\Meta;


/**
 * Interface DatabaseModelMetaDataInterface
 * @package Here\Config\Model\Meta
 */
interface DatabaseModelMetaDataInterface {
    /**
     * @param string $name
     * @param string[] $property
     */
    public function add_field(string $name, array $property): void;
}
