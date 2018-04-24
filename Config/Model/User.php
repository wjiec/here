<?php
/**
 * User.php
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Model;
use Here\Lib\Database\Model\DatabaseModelBase;


/**
 * Class User
 * @package Here\Config\Model
 */
final class User extends DatabaseModelBase {
    /**
     * @var int
     * @modelField
     * @fieldType serial
     * @fieldEmpty no
     * @fieldPrimary yes
     * @fieldAutoIncrement yes
     */
    public $uid;

    /**
     * @var string
     * @modelField
     * @fieldType varchar
     * @fieldLength 64
     * @fieldEmpty no
     * @fieldUnique yes
     */
    public $name;

    /**
     * @var string
     * @modelField
     * @fieldType varchar
     * @fieldLength 64
     * @fieldEmpty no
     */
    public $password;

    /**
     * @var string
     * @modelField
     * @fieldType varchar
     * @fieldLength 64
     * @fieldEmpty yes
     * @fieldDefault null
     */
    public $email;

    /**
     * @var string
     * @modelField
     * @fieldType varchar
     * @fieldLength 64
     * @fieldEmpty yes
     * @fieldDefault null
     */
    public $nickname;

    /**
     * @var string
     * @modelField
     * @fieldType varchar
     * @fieldLength 128
     * @fieldEmpty yes
     * @fieldDefault null
     */
    public $avatar;

    /**
     * @var string
     * @modelField
     * @fieldType text
     * @fieldEmpty yes
     * @fieldDefault null
     */
    public $description;
}
