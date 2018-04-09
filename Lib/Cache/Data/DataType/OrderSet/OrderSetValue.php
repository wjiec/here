<?php
/**
 * OrderSetValue.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType\OrderSet;
use Here\Lib\Cache\Data\CacheDataBase;


/**
 * Class OrderSetValue
 *
 * @package Here\Lib\Cache\Data\DataType\OrderSet
 */
final class OrderSetValue extends CacheDataBase implements OrderSetTypeInterface {
    /**
     * @param array $data
     */
    final public function assign(array $data): void {
        $this->destroy();
        $this->get_adapter()->order_set_add($this->get_key(), $data);
    }

    /**
     * @return array
     */
    final public function refresh_value() {
        $this->_value = $this->get_adapter()->order_set_get($this->get_key());
        return $this->_value;
    }

    /**
     * @return int
     */
    final public function get_length(): int {
        return count($this->get_value());
    }

    /**
     * @param int $score
     * @param string $value
     * @return int
     */
    final public function update(int $score, string $value): int {
        return $this->get_adapter()->order_set_add($this->get_key(), array($score => $value));
    }

    /**
     * @param string[] ...$values
     * @return int
     */
    final public function remove(string ...$values): int {
        return $this->get_adapter()->order_set_remove($this->get_key(), ...$values);
    }

    /**
     * @param string $value
     * @return int
     */
    final public function score(string $value): int {
        return $this->get_adapter()->order_set_score($this->get_key(), $value);
    }

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    final public function range(int $start, int $end): array {
        return $this->get_adapter()->order_set_range($this->get_key(), $start, $end);
    }

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    final public function reverse_range(int $start, int $end): array {
        return $this->get_adapter()->order_set_reverse_range($this->get_key(), $start, $end);
    }

    /**
     * @param string $value
     * @return int
     */
    final public function rank(string $value): int {
        return $this->get_adapter()->order_set_rank($this->get_key(), $value);
    }

    /**
     * @param string $value
     * @return int
     */
    final public function reverse_rank(string $value): int {
        return $this->get_adapter()->order_set_reverse_rank($this->get_key(), $value);
    }
}
