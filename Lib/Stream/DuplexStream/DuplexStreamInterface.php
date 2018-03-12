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
namespace Lib\Stream\DuplexStream;
use Lib\Stream\FileStreamInterface;
use Lib\Stream\IStream\ReaderStreamInterface;
use Lib\Stream\OStream\WriterStreamInterface;


/**
 * Interface DuplexStreamInterface
 * @package Lib\Stream\DuplexStream
 */
interface DuplexStreamInterface extends FileStreamInterface, ReaderStreamInterface, WriterStreamInterface {
}
