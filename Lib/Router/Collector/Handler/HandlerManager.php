<?php
/**
 * HandlerManager.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Handler;


/**
 * Class HandlerManager
 * @package Here\Lib\Router\Collector\Handler
 */
final class HandlerManager {
    /**
     * @var RouterHandler
     */
    private $_default_handler;

    /**
     * @var RouterHandler[]
     */
    private $_handlers;

    /**
     * HandlerManager constructor.
     */
    final public function __construct() {
        $this->_handlers = array();
        $this->_default_handler = null;
    }

    /**
     * @param RouterHandler $handler
     * @throws DuplicateDefaultHandler
     * @throws InvalidRouterHandler
     */
    final public function add_handler(RouterHandler $handler): void {
        if ($handler->is_default_handler()) {
            if ($this->_default_handler !== null) {
                throw new DuplicateDefaultHandler("duplicate default for `{$handler->get_component_name()}`");
            }
            $this->_default_handler = $handler;
        } else {
            $add_handler = $handler->get_add_handler_component();
            if ($add_handler === null) {
                throw new InvalidRouterHandler("Handler(`{$handler->get_component_name()}`) must be handle any error");
            }

            foreach ($add_handler as $error_code) {
                // It will override any defined handler
                $this->_handlers[$error_code] = $handler;
            }
        }
    }

    /**
     * @param int $error_code
     * @return RouterHandler|null
     */
    final public function get_handler(int $error_code): ?RouterHandler {
        return $this->_handlers[$error_code] ?? null;
    }

    /**
     * @return RouterHandler|null
     */
    final public function get_default_handler(): ?RouterHandler {
        return $this->_default_handler;
    }
}
