<?php
/**
 * FileReaderStream.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Lib\Stream\IStream\Local;
use Lib\Stream\FileStreamBase;
use Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Class FileReaderStream
 * @package Lib\Stream\IStream\Local
 */
class FileReaderStream extends FileStreamBase implements ReaderStreamInterface {
    /**
     * FileReaderStream constructor.
     * @param string $file_path
     */
    final public function __construct(string $file_path) {
        $this->open($file_path);
    }

    /**
     * @param int $number_of_size
     * @return string
     */
    final public function read(int $number_of_size = 0): string {
        return fread($this->_file_handler, $number_of_size);
    }

    /**
     * @return string
     */
    final public function read_line(): string {
        return fgets($this->_file_handler);
    }
}
