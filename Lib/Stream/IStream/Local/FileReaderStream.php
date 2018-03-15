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
namespace Here\Lib\Stream\IStream\Local;
use Here\Lib\Stream\FileStreamBase;
use Here\Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Class FileReaderStream
 * @package Lib\Stream\IStream\Local
 */
class FileReaderStream extends FileStreamBase implements ReaderStreamInterface {
    /**
     * @param int $number_of_size
     * @return string
     */
    final public function read(int $number_of_size = 0): string {
        if ($number_of_size === 0) {
            $number_of_size = filesize($this->_file_path);
        }
        return fread($this->_file_handler, $number_of_size);
    }

    /**
     * @return string
     */
    final public function read_line(): string {
        return fgets($this->_file_handler);
    }
}
