<?php
/**
 * TrueValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Filter\Validator;
use Here\Lib\Utils\Filter\FilterBase;


/**
 * Class TrueValidator
 * @package Lib\Utils\Filter\Validator
 */
final class TrueValidator extends FilterBase {
    /**
     * @return int
     */
    final protected static function filter_name(): int {
        return FILTER_VALIDATE_BOOLEAN;
    }
}
