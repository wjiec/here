<?php
/**
 * User.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Model;
use Here\Lib\Database\Model\Field\ModelField;
use Here\Lib\Database\Model\ModelBase;


/**
 * Class UserModel
 * @package Here\Config\Model
 */
final class User extends ModelBase {
    final protected static function fields(): array {
        return array(
            new ModelField('id', ModelSerial::create(), MODEL_OPT_NOT_NULL, MODEL_OPT_PRIMARY, MODEL_OPT_AUTO_INCREMENT),
            new ModelField('uuid', ModelUUID::create(), MODEL_OPT_NOT_NULL, MODEL_OPT_UNIQUE),
            new ModelField('name', ModelVarChar::create(64), MODEL_OPT_NOT_NULL, MODEL_OPT_UNIQUE)
        );
    }

    final protected static function attributes(): array {
        return array(
            new ModelAttribute(MODEL_ATTR_ENGINE, MODEL_ENGINE_INNODB),
            new ModelAttribute(MODEL_ATTR_AUTO_INC_START, 10)
        );
    }
}
