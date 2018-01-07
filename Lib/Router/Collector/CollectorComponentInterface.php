<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2018/1/7
 * Time: 19:14
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
