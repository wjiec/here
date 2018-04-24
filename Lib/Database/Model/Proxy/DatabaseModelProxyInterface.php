<?php
/**
 * DatabaseModelProxyInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model\Proxy;
use Here\Lib\Database\Model\DatabaseModelInterface;


/**
 * Interface DatabaseModelProxyInterface
 * @package Here\Lib\Database\Model\Proxy
 */
interface DatabaseModelProxyInterface {
    /**
     * DatabaseModelProxyInterface constructor.
     * @param DatabaseModelInterface $model
     */
    public function __construct(DatabaseModelInterface $model);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value): void;

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name);
}
