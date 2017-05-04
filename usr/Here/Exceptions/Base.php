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
    protected $_string_error_code;

    /**
     * current exceptions level
     *
     * @var string
     */
    protected $_exception_level;

    /**
     * Here_Exceptions_Base constructor.
     *
     * @param string $message
     * @param string $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code, Throwable $previous = null) {
        $this->_string_error_code = $code;
        $int_code = self::_find_error_code($code);
        $this->_exception_level = self::_find_error_level($code);
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
        return $this->_string_error_code;
    }

    /**
     * find error code from parameter, and convert to int
     *
     * @param string $string_code
     * @return int
     */
    private static function _find_error_code($string_code) {
        $code = intval($string_code);

        if ($code == 0) {
            for ($index = 0; $index < strlen($string_code); ++$index) {
                if (ctype_digit($string_code[$index])) {
                    $sub_str = substr($string_code, $index);
                    return intval($sub_str);
                }
            }
            $code = self::DEFAULT_ERROR_CODE;
        }

        return $code;
    }

    private static function _find_error_level($string_code) {
        $levels = explode(':', $string_code);
        $first_level = strtolower($levels[0]);

        switch ($first_level) {
            case 'fatal': $first_level = self::EXCEPTION_LEVEL_FATAL; break;
            case 'error': $first_level = self::EXCEPTION_LEVEL_ERROR; break;
            case 'warning': $first_level = self::EXCEPTION_LEVEL_WARNING; break;
            case 'ignore': /* to same default, ignore this error */
            default: $first_level = self::EXCEPTION_LEVEL_IGNORE; break;
        }

        // if bigger than notification_level,
        if ($first_level >= _here_notification_level) {
            /**
             * @TODO notification admin, e-mail
             */
        }
    }

    /**
     * it's default error code.
     *
     * @var int
     */
    const DEFAULT_ERROR_CODE = 1996;

    /**
     * exceptions level: Fatal
     *
     * @var int
     */
    const EXCEPTION_LEVEL_FATAL = 100;

    /**
     * exceptions level: Error
     *
     * @var int
     */
    const EXCEPTION_LEVEL_ERROR = 75;

    /**
     * exceptions level: Warning
     *
     * @var int
     */
    const EXCEPTION_LEVEL_WARNING = 50;

    /**
     * exceptions level: Ignore
     *
     * @var int
     */
    const EXCEPTION_LEVEL_IGNORE = 25;
}
