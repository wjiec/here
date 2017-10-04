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
use Here\Lib\Router\RouterMatch;


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
        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            new MethodParser($method);
        }
    }

    /**
     * @NotRouterNode
     * @param string $request_method
     * @param string $request_uri
     * @return RouterMatch
     */
    final public function resolve($request_method, $request_uri) {
    }
}
