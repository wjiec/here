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


/**
 * Class RouterChannel
 * @package Here\Lib\Router\Collector\Channel
 */
final class RouterChannel extends MetaComponent {
    /**
     * @var string
     */
    private $_channel_name;

    /**
     * RouterChannel constructor.
     * @param string $name
     * @param array $meta
     */
    final public function __construct(string $name, array $meta) {
        $this->_channel_name = $name;

        $allowed_syntax = AllowedChannelSyntax::get_constants();
        $this->compile_values($allowed_syntax, $meta);
    }
}
