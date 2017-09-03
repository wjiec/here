<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/9/3
 * Time: 21:41
 */
namespace Here\Lib\Interfaces;


/**
 * Interface ConfigInterface
 * @package Here\Lib\Interfaces
 */
interface ConfigInterface {
    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value);

    /**
     * @return bool
     */
    public function save();
}
