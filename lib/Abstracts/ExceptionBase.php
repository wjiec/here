<?php
/**
 * ExceptionBaseBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Abstracts;
use Here\Lib\Assert;
use Here\Lib\Autoloader;
use Here\Lib\Exception\ExceptionLevelError;
use Throwable;


/**
 * Class ExceptionBase
 * @package Here\Lib\Abstracts
 */
abstract class ExceptionBase extends \Exception {
    /**
     * error code
     *
     * @var string
     */
    protected $_code;

    /**
     * error message
     *
     * @var string
     */
    protected $_message;

    /**
     * @var
     */
    protected $_level;

    /**
     * ExceptionBase constructor.
     * @param string $message
     * @param string $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code, Throwable $previous = null) {
        Assert::String($message);
        Assert::String($code);

        $this->_parse_level($code);
        $this->_message = $message;

        parent::__construct('Please using ExceptionBase::get_message method',
            self::DEFAULT_ERROR_CODE, $previous);
    }

    /**
     * @return string
     */
    final public function get_code() {
        return $this->_code;
    }

    /**
     * @return string
     */
    final public function get_message() {
        return $this->_message;
    }

    /**
     * @param string $error_code
     * @throws ExceptionLevelError
     */
    final private function _parse_level($error_code) {
        if (strpos($error_code, ':') !== false) {
            $segments = explode(':', $error_code);
            $level = strtolower($segments[0]);

            array_shift($segments);
            $error_code = join(':', $segments);
        } else {
            $level = self::DEFAULT_ERROR_LEVEL;
        }
        $level_class = join('\\', array('', 'Here', 'Lib', 'Exception', 'Level', ucfirst($level)));
        if (!Autoloader::class_exists($level_class)) {
            throw new ExceptionLevelError('cannot resolve exception level',
                'Here:Lib:Exception:ExceptionBase');
        }

        $this->_code = $error_code;
        $this->_level = new $level_class();
    }

    /**
     * default error level
     */
    const DEFAULT_ERROR_LEVEL = 'error';

    /**
     * default error code
     */
    const DEFAULT_ERROR_CODE = 1996;
}
