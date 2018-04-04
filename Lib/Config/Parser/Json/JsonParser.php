<?php
/**
 * JsonParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Parser\Json;
use Here\Lib\Config\ConfigObject;
use Here\Lib\Config\Parser\ConfigParserBase;
use Here\Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Class JsonParser
 * @package Here\Lib\Config\Parser\Json
 */
final class JsonParser extends ConfigParserBase {
    /**
     * @param ReaderStreamInterface $stream
     * @return ConfigObject|null
     * @throws JsonConfigInvalid
     */
    final protected function parse_config(ReaderStreamInterface $stream): ?ConfigObject {
        try {
            $parse_object = json_decode($stream->read(), true);
            return new ConfigObject($parse_object);
        } catch (\Exception $e) {
            throw new JsonConfigInvalid("configure file `{$stream->get_name()}` invalid: {$e->getMessage()}");
        }
    }

    /**
     * @param ConfigObject $config
     * @return null|string
     */
    final protected function dump_config(ConfigObject $config): ?string {
        return self::json_readable_encode($config->to_array());
    }

    /**
     * @param array $config
     * @param int $indent_size
     * @param string $indent
     * @return string
     */
    final private static function json_readable_encode(array $config,
                                                       int $indent_size = 0, string $indent = '  '): string {
        $escape_func = function ($str) {
            return preg_replace("!([\b\t\n\r\f\"\\'])!", "\\\\\\1", $str);
        };

        $stringify_config = '';
        foreach ($config as $key => $value) {
            $stringify_config .= str_repeat($indent, $indent_size + 1);
            $stringify_config .= "\"" . $escape_func((string)$key) . "\": ";

            if (is_object($value) || is_array($value)) {
                $stringify_config .= "\n";
                $stringify_config .= self::json_readable_encode($value, $indent_size + 1, $indent);
            } else if (is_bool($value)) {
                $stringify_config .= $value ? 'true' : 'false';
            } else if (is_null($value)) {
                $stringify_config .= 'null';
            } elseif (is_string($value)) {
                $stringify_config .= "\"" . $escape_func($value) ."\"";
            } else {
                $stringify_config .= $value;
            }

            $stringify_config .= ",\n";
        }

        if (!empty($stringify_config)) {
            $stringify_config = substr($stringify_config, 0, -2);
        }

        $stringify_config = str_repeat($indent, $indent_size) . "{\n" . $stringify_config;
        $stringify_config .= "\n" . str_repeat($indent, $indent_size) . "}";

        return $stringify_config;
    }
}
