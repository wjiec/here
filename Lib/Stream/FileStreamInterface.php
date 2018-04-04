<?php
/**
 * FileStreamInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream;


/**
 * Interface FileStreamInterface
 * @package Lib\Stream
 */
interface FileStreamInterface extends StreamInterface {
    /**
     * @param string $file_path
     */
    public function open(string $file_path): void;

    /**
     * @return string
     */
    public function get_name(): string;
}
