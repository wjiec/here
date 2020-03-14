<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Limiter;

use Phalcon\Cache\BackendInterface;


/**
 * Class Limiter
 * @package Here\Provider\Limiter
 */
class Limiter {

    /**
     * The name of the limiter
     *
     * @var string
     */
    protected $name;

    /**
     * Lifetime of the limiter
     *
     * @var int
     */
    protected $lifetime;

    /**
     * @var BackendInterface
     */
    protected $cache;

    /**
     * Limiter constructor.
     * @param string $name
     * @param int $lifetime
     */
    public function __construct(string $name, int $lifetime = 300) {
        $this->name = "limiter:{$name}";
        $this->lifetime = $lifetime;
        $this->cache = container('cache');
    }

    /**
     * Enter the limiter
     *
     * @param string $source
     * @param int $max_count
     * @return bool
     */
    public function enter(string $source, int $max_count = self::COUNT_TO_FORBIDDEN): bool {
        $limiter_name = "{$this->name}:{$source}";
        $value = (int)$this->cache->get($limiter_name);
        if ($value >= $max_count) {
            return false;
        }

        $this->cache->save($limiter_name, $value + 1, $this->lifetime);
        return true;
    }

    /**
     * @const COUNT_TO_FORBIDDEN The number of the retry count of login to forbidden
     */
    protected const COUNT_TO_FORBIDDEN = 6;

}
