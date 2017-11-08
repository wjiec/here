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
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterChannel
 * @package Here\Lib\Router\Collector\Channel
 */
final class RouterChannel extends MetaComponent {
    /**
     * RouterChannel constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     */
    final public function __construct(string $name, array $meta, RouterCallback $callback) {
        $this->set_component_name($name);
        $allowed_syntax = AllowedChannelSyntax::get_constants();
        $this->compile_values($allowed_syntax, $meta);
    }
}
