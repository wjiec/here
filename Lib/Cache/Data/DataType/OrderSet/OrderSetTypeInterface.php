<?php
/**
 * OrderSetTypeInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\OrderSet;


/**
 * Interface OrderSetTypeInterface
 *
 * @package Here\Lib\Cache\Data\DataType\OrderSet
 */
interface OrderSetTypeInterface {
    /**
     * @param array $data
     */
    public function assign(array $data): void;

    /**
     * @param int $score
     * @param string $value
     * @return int
     */
    public function update(int $score, string $value): int;

    /**
     * @param string[] $values
     * @return int
     */
    public function remove(string ...$values): int;

    /**
     * @param string $value
     * @return int
     */
    public function score(string $value): int;

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    public function range(int $start, int $end): array;

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    public function reverse_range(int $start, int $end): array;

    /**
     * @param string $value
     * @return int
     */
    public function rank(string $value): int;

    /**
     * @param string $value
     * @return int
     */
    public function reverse_rank(string $value): int;
}
