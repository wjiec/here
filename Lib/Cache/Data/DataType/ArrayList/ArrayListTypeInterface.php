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
     * @param array ...$values
     * @return int
     */
    public function push(...$values): int;

    /**
     * @param mixed|null $default
     * @return mixed
     */
    public function pop($default = null);

    /**
     * @param array ...$values
     * @return int
     */
    public function unshift(...$values): int;

    /**
     * @param mixed|null $default
     * @return mixed
     */
    public function shift($default = null);
}
