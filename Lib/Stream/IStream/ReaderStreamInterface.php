<?php
/**
 * ReaderStreamInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream;
use Here\Lib\Stream\FileStreamInterface;


/**
 * Interface ReaderStreamInterface
 * @package Lib\Stream\IStream
 */
interface ReaderStreamInterface extends FileStreamInterface {
    /**
     * @param int $number_of_size
     * @return string
     */
    public function read(int $number_of_size = 0): string;

    /**
     * @return string
     */
    public function read_line(): string;
}
