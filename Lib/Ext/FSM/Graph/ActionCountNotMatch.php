<?php
/**
 * TooLittleAction.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\FSM\Graph;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class TooLittleAction
 * @package Here\Lib\Ext\FSM\Graph
 */
final class ActionCountNotMatch extends ExceptionBase {
    use Error;
}
