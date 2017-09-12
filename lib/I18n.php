<?php
/**
 * I18n.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib;


/**
 * Class I18n
 * @package Here\Lib
 */
class I18n {
    /**
     * @param string $string_flag
     */
    final public static function _T($string_flag) {
        // @TODO
        echo Toolkit::_($string_flag);
    }
}
