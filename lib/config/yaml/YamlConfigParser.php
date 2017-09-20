<?php
/**
 * YamlConfigParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Yaml;


class YamlConfigParser {
    /**
     * @var array
     */
    private $_lines;

    /**
     * @var int
     */
    private $_skip_line_count;

    /**
     * @var string
     */
    private $_current_line;

    /**
     * YamlConfigParser constructor.
     */
    final public function __construct() {}

    /**
     * @param string $contents
     * @return array
     */
    final public function parse($contents) {
        $this->_skip_line_count = 0;
        $this->_current_line = '';
        $this->_lines = explode("\n", $this->_normalize($contents));

        return array();
    }

    /**
     * @param string $contents
     * @throws YamlInvalidError
     * @return string
     */
    final private function _normalize($contents) {
        // check multi documents
        if (preg_match_all("/^\-\-\-.*?\n/sm", $contents) > 1) {
            throw new YamlInvalidError("expected a single document in the stream, but found more");
        }

        // replace \r\n and \r to \n
        $contents = str_replace(array("\r\n", "\r"), "\n", $contents);

        // check last line is `\n`
        if (!preg_match("/\n$/", $contents)) {
            $contents .= "\n";
        }

        // skip Yaml 1.2 header `%YAML: 1.2`
        $contents = preg_replace("/^\%YAML[: ][\d\.]+.*\n/", '', $contents, -1, $replace_count);
        $this->_skip_line_count += $replace_count;

        // skip leading comments or `---` document delimiter
        $trimmed = preg_replace("/^\s*((\-\-\-.*?\n)|(#.*?\n))*/s", '', $contents, -1, $replace_count);
        if ($replace_count === 1) {
            $this->_skip_line_count += substr_count($contents, "\n") - substr_count($trimmed, "\n");
            $contents = $trimmed;
        }

        return $contents;
    }
}
