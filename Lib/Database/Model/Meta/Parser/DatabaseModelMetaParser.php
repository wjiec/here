<?php
/**
 * DatabaseModelMetaParser.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model\Meta\Parser;
use Here\Lib\Utils\Toolkit\StringToolkit;


/**
 * Class DatabaseModelMetaParser
 * @package Here\Config\Model\Meta\Parser
 */
final class DatabaseModelMetaParser {
    /**
     * @param string $comments
     * @return string[]
     */
    final public static function parse(string $comments): array {
        $comments = StringToolkit::crlf_to_lf($comments);

        $properties = array();
        foreach (explode("\n", $comments) as $comment) {
            if (preg_match("/@field(?<name>\w+)\s*(?<value>.*)/", $comment, $matches)) {
                $properties[$matches['name']] = $matches['value'];
            }
        }

        return $properties;
    }
}
