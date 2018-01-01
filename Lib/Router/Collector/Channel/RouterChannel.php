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
use Here\Lib\Router\Collector\MetaComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods\AddMethods;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterChannel
 * @package Here\Lib\Router\Collector\Channel
 */
final class RouterChannel {
    /**
     * meta components utils
     */
    use MetaComponent;

    /**
     * @var string
     */
    private $_channel_name;

    /**
     * RouterChannel constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     * @throws InvalidChannel
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\CompilerNotFound
     */
    final public function __construct(string $name, array $meta, RouterCallback $callback) {
        $this->_channel_name = $name;

        $allowed_syntax = AllowedChannelSyntax::get_constants();
        $this->compile_components($allowed_syntax, $meta);

        if (!$this->has_methods_component() || !$this->has_url_component()) {
            throw new InvalidChannel("channel `{$this->_channel_name}` invalid, because missing method/url syntax");
        }
    }

    /**
     * @return string
     */
    final public function get_channel_name(): string {
        return $this->_channel_name;
    }

    /**
     * @return bool
     */
    final public function has_methods_component(): bool {
        return $this->has_component(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_METHODS);
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
     * @return bool
     */
    final public function has_url_component(): bool {
        return $this->has_component(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_URL);
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
     * @return bool
     */
    final public function has_middleware_component(): bool {
        return $this->has_component(AllowedChannelSyntax::CHANNEL_SYNTAX_ADD_MIDDLEWARE);
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
