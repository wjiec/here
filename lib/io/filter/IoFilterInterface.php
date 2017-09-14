<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/9/13
 * Time: 23:30
 */
namespace Here\Lib\Io\Filter;


/**
 * Interface IoFilterInterface
 * @package Here\Lib\IO
 */
interface IoFilterInterface {
    /**
     * @param string $validator
     * @param int $flags
     * @return $this
     */
    public function validate($validator, $flags);

    /**
     * @param string $sanitizer
     * @param int $flags
     * @return $this
     */
    public function sanitize($sanitizer, $flags);

    /**
     * @param callable $callback
     * @return $this
     */
    public function callback($callback);

    /**
     * @param mixed $object
     * @param mixed|null $default
     * @return mixed|null
     */
    public function apply($object, $default = null);
}
