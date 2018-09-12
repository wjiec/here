<?php
/**
 * Validator.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 */
namespace Here\Libraries\Signature;


/**
 * Class Validator
 * @package Here\Libraries\Signature
 */
final class Validator {

    /**
     * Validator constructor.
     */
    final public function __construct() {
    }

    /**
     * @return Context
     */
    final public function generateContext(): Context {
        return new Context();
    }

}
