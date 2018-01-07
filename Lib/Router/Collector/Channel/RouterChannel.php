<?php
/**
 * RouterChannel.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Router\Collector\CollectorComponentBase;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods\AddMethods;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterChannel
 * @package Here\Lib\Router\Collector\Channel
 */
final class RouterChannel extends CollectorComponentBase {
    /**
     * RouterChannel constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     * @throws InvalidChannel
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\CompilerNotFound
     */
    final public function __construct(string $name, array $meta, RouterCallback $callback) {
        parent::__construct($name, $meta, $callback);

        if ($this->get_methods_component() === null || $this->get_url_component() === null) {
            $channel_name = $this->get_component_name();
            throw new InvalidChannel("channel `{$channel_name}` invalid, because missing method/url meta");
        }
    }

    /**
     * @return array
     */
    final protected function _allowed_syntax(): array {
        return AllowedChannelSyntax::get_constants();
    }

    /**
     * @return AddMethods|null
     */
    final public function get_methods_component(): ?AddMethods {
        /* @var AddMethods $methods_component */
        $methods_component = $this->get_components(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_METHODS);
        return $methods_component;
    }

    /**
     * @return AddUrl|null
     */
    final public function get_url_component(): ?AddUrl {
        /* @var AddUrl $url_component */
        $url_component = $this->get_components(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_URL);
        return $url_component;
    }

    /**
     * @return AddMiddleware|null
     */
    final public function get_middleware_component(): ?AddMiddleware {
        /* @var AddMiddleware $middleware_component */
        $middleware_component = $this->get_components(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_MIDDLEWARE);
        return $middleware_component;
    }
}
