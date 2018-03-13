<?php
/**
 * CollectorComponentInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\RouterCallback;


/**
 * Interface CollectorComponent
 * @package Here\Lib\Router\Collector
 */
interface CollectorComponentInterface {
    /**
     * CollectorComponent constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     */
    public function __construct(string $name, array $meta, RouterCallback $callback);
}
