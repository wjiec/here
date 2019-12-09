<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Library\Creation\Article\Metadata;


/**
 * Class Parser
 * @package Here\Library\Creation\Article\Metadata
 */
class Parser {

    /**
     * Parse the metadata from contents
     *
     * @param string $content
     * @return Metadata
     */
    public static function parse(string $content): Metadata {
        return new Metadata([]);
    }

}
