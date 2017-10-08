<?php
/**
 * SyntaxAddMethodsParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta\Syntax;
use Here\Lib\Router\Collector\Method\Meta\MetaItem;
use Here\Lib\Router\Collector\Method\Meta\Syntax\Result\AddMethodParseResult;
use Here\Lib\Router\Collector\Method\Meta\Syntax\Result\MetaParseResultInterface;
use Here\Lib\Router\Dispatcher;


/**
 * Class SyntaxAddMethodsParser
 * @package Here\Lib\Router\Collector\Method\Meta\Syntax
 */
class SyntaxAddMethodsParser implements MetaSyntaxParserInterface {
    /**
     * @param MetaItem $item
     * @return MetaParseResultInterface
     */
    public function parse(MetaItem $item) {
        $methods = array_filter(explode(',', $item->get_value()), function($method) {
            return in_array(strtolower(trim($method)), Dispatcher::ALLOWED_METHODS);
        });

        return new AddMethodParseResult(array_map(function($method) {
            return strtolower($method);
        }, $methods));
    }
}
