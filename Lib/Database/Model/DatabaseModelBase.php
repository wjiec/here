<?php
/**
 * DatabaseModelBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model;


/**
 * Class DatabaseModelBase
 * @package Here\Lib\Database\Model
 */
abstract class DatabaseModelBase implements DatabaseModelInterface {
    /**
     * @var int
     * @modelField
     * @fieldType int
     * @fileLength 11
     * @fieldEmpty no
     */
    public $create_at;

    /**
     * @var int
     * @modelField
     * @fieldType int
     * @fieldLength 11
     * @fieldEmpty no
     */
    public $update_at;
}
