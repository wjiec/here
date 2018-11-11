<?php
/**
 * Validator.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
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
