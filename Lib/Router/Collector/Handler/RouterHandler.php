<?php
/**
 * RouterHandler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Handler;
use Here\Lib\Router\Collector\CollectorComponentBase;


/**
 * Class RouterHandler
 * @package Here\Lib\Router\Collector\Handler
 */
final class RouterHandler extends CollectorComponentBase {
    /**
     * @return array
     */
    final protected function _allowed_syntax(): array {
        return array();
    }
}
