<?php
/**
 * MetaParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta;
use Here\Lib\Autoloader;


/**
 * Class MetaParser
 * @package Here\Lib\Router\Collector\Meta
 */
final class MetaParser {
    /**
     * MetaParser constructor.
     */
    final public function __construct() {}

    /**
     * @param string $meta_string
     * @return bool|MetaGroup
     */
    final public function parse($meta_string) {
        $meta_string = trim($meta_string);
        if (strlen($meta_string) === 0) {
            return false;
        }

        /* @var MetaItem $item */
        foreach (new MetaGroup($meta_string) as $item) {
            $parser_name = sprintf('%s\Syntax\Syntax%sParser', __NAMESPACE__, ucfirst($item->name));

            if (!Autoloader::class_exists($parser_name)) {
                continue;
            }

            var_dump($parser_name);
            $parser = new $parser_name();
        }
    }
}
