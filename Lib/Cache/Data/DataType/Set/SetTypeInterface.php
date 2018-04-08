<?php
/**
 * SetTypeInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\Set;


/**
 * Interface SetTypeInterface
 * @package Here\Lib\Cache\Data\DataType\Set
 */
interface SetTypeInterface {
    /**
     * @param array $set
     */
    public function assign(array $set): void;

    /**
     * @param string[] ...$values
     * @return int
     */
    public function add(string ...$values): int;

    /**
     * @param string[] ...$values
     * @return int
     */
    public function remove(string ...$values): int;

    /**
     * @param string $value
     * @return bool
     */
    public function exists(string $value): bool;

    /**
     * @param null|string $default
     * @return null|string
     */
    public function random_pop(?string $default = null): ?string;

    /**
     * @param null|string $default
     * @return null|string
     */
    public function random_cat(?string $default = null): ?string;

    /**
     * @param SetTypeInterface[] $keys
     * @return array
     */
    public function inter(SetTypeInterface ...$keys): array;

    /**
     * @param SetTypeInterface[] ...$keys
     * @return array
     */
    public function union(SetTypeInterface ...$keys): array;

    /**
     * @param SetTypeInterface[] ...$keys
     * @return array
     */
    public function diff(SetTypeInterface ...$keys): array;
}
