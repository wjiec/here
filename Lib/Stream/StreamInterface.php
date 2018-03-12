<?php
/**
 * StreamInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Lib\Stream;


/**
 * Interface StreamInterface
 * @package Lib\Stream
 */
interface StreamInterface {
    /**
     * close stream
     */
    public function close(): void;

    /**
     * reset stream to initial
     */
    public function reset(): void;
}
