<?php
/**
 * DuplexStreamInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\DuplexStream;
use Here\Lib\Stream\FileStreamInterface;
use Here\Lib\Stream\IStream\ReaderStreamInterface;
use Here\Lib\Stream\OStream\WriterStreamInterface;


/**
 * Interface DuplexStreamInterface
 * @package Lib\Stream\DuplexStream
 */
interface DuplexStreamInterface extends FileStreamInterface, ReaderStreamInterface, WriterStreamInterface {
}
