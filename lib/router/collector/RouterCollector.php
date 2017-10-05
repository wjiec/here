<?php
/**
 * RouterCollector.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\Method\MethodParser;
use Here\Lib\Router\Collector\Method\MethodParseResult;


/**
 * Class RouterCollector
 * @package Here\Lib\Router\Collector
 */
abstract class RouterCollector {
    /**
     * @NotRouterNode
     * RouterCollector constructor.
     */
    final public function __construct() {
        $method_parser = new MethodParser();

        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            var_dump($method);
            /* @var MethodParseResult $method_info */
            $method_info = $method_parser->parse($method);
            if (!$method_info || !$method_info->get_available()) {
                continue;
            }

            var_dump($method_info);
        }
    }
}
