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
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddHandler\AddHandler;


/**
 * Class RouterHandler
 * @package Here\Lib\Router\Collector\Handler
 */
final class RouterHandler extends CollectorComponentBase {
    /**
     * @return array
     */
    final protected function _allowed_syntax(): array {
        return AllowedHandlerSyntax::get_constants();
    }

    /**
     * @return bool
     */
    final public function is_default_handler(): bool {
        return $this->has_component(AllowedHandlerSyntax::HANDLER_SYNTAX_DEFAULT_HANDLER);
    }

    /**
     * @return AddHandler|null
     */
    final public function get_add_handler_component(): ?AddHandler {
        /* @var AddHandler|null $add_handler */
        $add_handler = $this->get_components(AllowedHandlerSyntax::HANDLER_SYNTAX_ADD_HANDLER);
        return $add_handler;
    }
}
