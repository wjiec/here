<?php
/**
 * Action.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Action;


/**
 * Class Action
 * @package Here\Lib\Router\Action
 */
final class RouterAction {
    /**
     * @var bool
     */
    private $_valid;

    /**
     * RouterAction constructor.
     * @param \ReflectionMethod $method
     */
    final public function __construct(\ReflectionMethod $method) {
        $comments = self::_normalize_comments($method->getDocComment());

        // check comments length gt 0
        if (strlen($comments) === 0) {
            $this->_valid = false;
            return;
        }

        $this->_valid = true;
        $this->_analysis_comments($comments);
    }

    /**
     * @return bool
     */
    final public function valid() {
        return $this->_valid;
    }

    /**
     * @param string $comments
     */
    final private function _analysis_comments($comments) {
        foreach (explode("\n", $comments) as $line) {
            if (preg_match('/@(?<name>\w+)\s*(?<value>.*)?/', $line, $matches)) {
                var_dump($matches['name'], $matches['value']);
            }
        }
    }

    /**
     * @param string $comments
     * @return string
     */
    final private static function _normalize_comments($comments) {
        return str_replace(array("\r\n", "\r"), "\n", trim($comments));
    }
}
