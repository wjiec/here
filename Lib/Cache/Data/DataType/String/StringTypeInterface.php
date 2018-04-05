<?php
/**
 * StringTypeInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\String;


/**
 * Interface StringTypeInterface
 * @package Here\Lib\Cache\Data\DataType\String
 */
interface StringTypeInterface {
    /**
     * @param string $data
     */
    public function assign(string $data): void;

    /**
     * @param string $concat_string
     * @return int
     */
    public function concat(string $concat_string): int;

    /**
     * @return int
     */
    public function increment(): int;

    /**
     * @return int
     */
    public function decrement(): int;
}
