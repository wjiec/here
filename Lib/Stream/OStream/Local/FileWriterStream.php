<?php
/**
 * FileWriterStream.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Local;
use Here\Lib\Stream\FileStreamBase;
use Here\Lib\Stream\OStream\WriterStreamInterface;


/**
 * Class FileWriterStream
 * @package Lib\Stream\OStream\Local
 */
class FileWriterStream extends FileStreamBase implements WriterStreamInterface {
    /**
     * @param string $buffer
     * @return int
     */
    final public function write(string $buffer): int {
        $result = fwrite($this->_file_handler, $buffer);
        return is_bool($result) ? 0 : $result;
    }

    /**
     * @param array $lines
     */
    final public function write_lines(array $lines): void {
        array_map(function($line) {
            $this->write($line . "\n");
        }, $lines);
    }
}
