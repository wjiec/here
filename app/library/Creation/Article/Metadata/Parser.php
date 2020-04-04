<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Creation\Article\Metadata;

use Here\Library\Exception\Metadata\MetadataParseException;
use Here\Library\Utils\Text;


/**
 * Class Parser
 * @package Here\Library\Creation\Article\Metadata
 */
class Parser {

    /**
     * @var string[]
     */
    protected $lines;

    /**
     * Parser constructor.
     * @param array $lines
     */
    private function __construct(array $lines) {
        $this->lines = $lines;
    }

    /**
     * Parse the metadata from contents
     *
     * @param string $content
     * @return Metadata
     * @throws MetadataParseException
     */
    public static function parse(string $content): Metadata {
        $lines = Text::lines($content);
        return (new static(array_values($lines)))->metadata();
    }

    /**
     * Parse and make metadata returns
     *
     * @param int $index
     * @return Metadata
     * @throws MetadataParseException
     */
    public function metadata(int $index = 0): Metadata {
        $metadata = null;
        // Check metadata exists
        for (; $index < count($this->lines); ++$index) {
            if (!static::isBlank($this->lines[$index])) {
                if (static::isMetadataIdentify($this->lines[$index])) {
                    $metadata = $this->fromMetadataBlock($index + 1, $index);
                }
                break;
            }
        }
        // When metadata empty, Checks title of section
        if ($metadata === null) {
            $metadata = $this->fromRawMarkdown($index, $index);
        }

        return $metadata->setBody(trim(Text::concat(array_splice($this->lines, $index))));
    }

    /**
     * Built the metadata from offset in the lines
     *
     * @param int $offset
     * @param int $index
     * @return Metadata
     * @throws MetadataParseException
     */
    protected function fromMetadataBlock(int $offset, int &$index): Metadata {
        $metadata = [];
        for ($last = null; $offset < count($this->lines); ++$offset) {
            switch (true) {
                case static::isMetadataIdentify($this->lines[$offset]):
                    $index = $offset + 1;
                    return new Metadata($metadata);
                case ($pair = static::isMetadataPair($this->lines[$offset])):
                    list($last, $value) = $pair;
                    $metadata[$last] = $value;
                    break;
                case ($part = static::isMetadataContinue($this->lines[$offset])):
                    if ($last && isset($metadata[$last])) {
                        $metadata[$last] .= " {$part}";
                    }
                    break;
                case static::isBlank($this->lines[$offset]):
                case static::isCommentLine($this->lines[$offset]);
                    break;
                default:
                    throw new MetadataParseException("invalid metadata `{$this->lines[$offset]}`");
            }
        }
        throw new MetadataParseException("The end token missing of metadata");
    }

    /**
     * Built the metadata from markdown raw
     *
     * @param int $offset
     * @param int $index
     * @return Metadata
     */
    protected function fromRawMarkdown(int $offset, int &$index): Metadata {
        $metadata = [];
        if (preg_match('/^#+\s*(?<t>.*)$/', $this->lines[$offset], $matches)) {
            $metadata['title'] = trim($matches['t']);
            $offset += 1;
        } else if (($offset < count($this->lines)) && preg_match('/^-{3,}$/', $this->lines[$offset + 1])) {
            $metadata['title'] = trim($this->lines[$offset]);
            $offset += 2;
        }

        $index = $offset;
        return new Metadata($metadata);
    }

    /**
     * Returns true when text blank
     *
     * @param string $text
     * @return bool
     */
    protected static function isBlank(string $text): bool {
        return !!preg_match('/^\s*$/', $text);
    }

    /**
     * Returns true when text starts with ///---*
     *
     * @param string $text
     * @return bool
     */
    protected static function isMetadataIdentify(string $text): bool {
        return !!preg_match('/^\/\/\/-{3,}/', $text);
    }

    /**
     * Returns true when text starts with //#
     *
     * @param string $text
     * @return bool
     */
    protected static function isCommentLine(string $text): bool {
        return !!preg_match('/^\/\/#.*$/', $text);
    }

    /**
     * Returns [key, value] when text is valid pair
     *
     * @param string $text
     * @return array|null
     */
    protected static function isMetadataPair(string $text): ?array {
        if (preg_match('/^\/\/@(?<k>\w+)\s*(?<v>.*)$/', $text, $matches)) {
            return [$matches['k'], trim($matches['v'])];
        }
        return null;
    }

    /**
     * Returns the continues parts when text is part of last pair
     *
     * @param string $text
     * @return string|null
     */
    protected static function isMetadataContinue(string $text): ?string {
        if (preg_match('/^\/\/\s(?<p>.+)$/', $text, $matches)) {
            return trim($matches['p']);
        }
        return null;
    }

}
