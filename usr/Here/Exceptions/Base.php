<?php
/**
 * Here Base Exceptions
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Exception: Here_Exceptions_Base
 */
class Here_Exceptions_Base extends Exception {
    /**
     * string error code.
     *
     * @var string
     */
    protected $string_error_code;

    /**
     * Here_Exceptions_Base constructor.
     *
     * @param string $message
     * @param string $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code, Throwable $previous = null) {
        $this->string_error_code = $code;
        $int_code = self::_find_error_code($code);
        if ($int_code == self::DEFAULT_ERROR_CODE) {
            $this->message = join('', array($this->message, strval($int_code)));
        }

        parent::__construct($message, $int_code, $previous);
    }

    /**
     * Override method: from Exception getting error message
     *
     * @return string
     */
    public function get_message() {
        return $this->message;
    }

    /**
     * Override method: from Exception getting origin error code
     *
     */
    public function get_code() {
        return $this->string_error_code;
    }

    /**
     * find error code from parameter, and convert to int
     *
     * @param string $string_code
     */
    public static function _find_error_code($string_code) {
        $code = intval($string_code);

        if ($code == 0) {
            for ($index = 0; $index < strlen($string_code); ++$index) {
                if (ctype_alnum($string_code[$index])) {
                    $sub_str = substr($string_code, $index);
                    return intval($sub_str);
                }
            }
            $code = self::DEFAULT_ERROR_CODE;
        }

        return $code;
    }

    /**
     * it's default error code.
     *
     * @var int
     */
    const DEFAULT_ERROR_CODE = 1996;
}
