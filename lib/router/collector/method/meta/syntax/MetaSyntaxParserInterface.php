<?php
/**
 * MetaSyntaxInterfact.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta\Syntax;
use Here\Lib\Router\Collector\Method\Meta\MetaItem;
use Here\Lib\Router\Collector\Method\Meta\Syntax\Result\MetaParseResultInterface;


/**
 * Interface MetaSyntaxInterface
 * @package Here\Lib\Router\Collector\Meta\Syntax
 */
interface MetaSyntaxParserInterface {
    /**
     * @param MetaItem $item
     * @return MetaParseResultInterface
     */
    public function parse(MetaItem $item);
}
