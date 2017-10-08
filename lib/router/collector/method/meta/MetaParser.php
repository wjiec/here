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
use Here\Lib\Router\Collector\Method\Meta\Syntax\MetaSyntaxParserInterface;


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
     * @return bool|MetaParseResult
     */
    final public function parse($meta_string) {
        $meta_string = trim($meta_string);
        if (strlen($meta_string) === 0) {
            return false;
        }

        $meta_result = new MetaParseResult();
        /* @var MetaItem $item */
        foreach (new MetaGroup($meta_string) as $item) {
            $parser_name = sprintf('%s\Syntax\Syntax%sParser',
                __NAMESPACE__, ucfirst($item->get_name()));

            if (!Autoloader::class_exists($parser_name)) {
                continue;
            }

            /* @var MetaSyntaxParserInterface $parser */
            $parser = new $parser_name();
            $result = $parser->parse($item);
            if (!$result->is_available()) {
                continue;
            }

            $meta_result->set_item(new MetaItem($item->get_name(), $result));
        }

        return $meta_result;
    }

    /**
     * @var array
     */
    const ALLOWED_SYNTAX = array(

    );
}
