<?php
/**
 * HashTableTypeInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\HashTable;


/**
 * Interface HashTableTypeInterface
 * @package Here\Lib\Cache\Data\DataType\HashTable
 */
interface HashTableTypeInterface extends \ArrayAccess {
    /**
     * @param array $data
     */
    public function assign(array $data): void;

    /**
     * @param null $default
     * @param string[] $indexes
     * @return array
     */
    public function multi_get($default = null, array $indexes): array;

    /**
     * @param string[] $indexes
     * @return int
     */
    public function multi_remove(array $indexes): int;

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data): int;

    /**
     * @return array
     */
    public function keys(): array;

    /**
     * @return array
     */
    public function values(): array;
}
