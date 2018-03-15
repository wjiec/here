<?php
/**
 * WriterStreamInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream;
use Here\Lib\Stream\FileStreamInterface;


/**
 * Interface WriterStreamInterface
 * @package Lib\Stream\OStream
 */
interface WriterStreamInterface extends FileStreamInterface {
    /**
     * @param string $buffer
     * @return int
     */
    public function write(string $buffer): int;

    /**
     * @param array $lines
     */
    public function write_lines(array $lines): void;
}
