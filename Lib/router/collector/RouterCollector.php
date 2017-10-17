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
use Here\Lib\Router\Action\RouterAction;


/**
 * Class RouterCollector
 * @package Here\Lib\Router\Collector
 */
abstract class RouterCollector {
    /**
     * @var array
     */
    private $_route_action;

    /**
     * @var array
     */
    private $_error_action;

    /**
     * @var array
     */
    private $_hooks_action;


    /**
     * @NotRouterAction
     * RouterCollector constructor.
     */
    final public function __construct() {
        $this->_route_action = array();
        $this->_error_action = array();
        $this->_hooks_action = array();

        // reflection `Collector`
        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            // skip method of current class
            if ($method->class === __CLASS__ || $method->name[0] === '_') {
                continue;
            }

            $this->_analysis_action(new RouterAction($method));
        }
    }

    /**
     * @param RouterAction $action
     */
    final private function _analysis_action(RouterAction $action) {
        if (!$action->valid()) {
            return;
        }

        var_dump($action);
    }
}
