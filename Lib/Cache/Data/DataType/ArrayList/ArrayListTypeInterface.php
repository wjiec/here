<?php
/**
 * ArrayListTypeInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\ArrayList;


/**
 * Interface ArrayListTypeInterface
 * @package Here\Lib\Cache\Data\DataType\ArrayList
 */
interface ArrayListTypeInterface extends \ArrayAccess {
    /**
     * @param array $data
     */
    public function assign(array $data): void;

    /**
     * @param string[] ...$values
     * @return int
     */
    public function push(string ...$values): int;

    /**
     * @param null|string $default
     * @return null|string
     */
    public function pop(?string $default = null): ?string;

    /**
     * @param string[] ...$values
     * @return int
     */
    public function unshift(string ...$values): int;

    /**
     * @param null|string $default
     * @return null|string
     */
    public function shift(?string $default = null): ?string;
}
