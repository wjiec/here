<?php
/**
 * DatabaseModelProxy.php
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
 * Class DatabaseModelProxy
 *
 * @package Here\Lib\Database\Model\Proxy
 */
final class DatabaseModelProxy implements DatabaseModelProxyInterface {
    /**
     * @var DatabaseModelInterface
     */
    private $model;

    /**
     * DatabaseModelProxy constructor.
     * @param DatabaseModelInterface $model
     */
    final public function __construct(DatabaseModelInterface $model) {
        $this->model = $model;
    }

    /**
     * @param string $name
     * @return mixed
     */
    final public function __get(string $name) {
        $method = "set_{$name}";
        if (!method_exists($this->model, $method)) {
            echo 'not found method';
        }

        try {
            return $this->model->{$method}();
        } catch (\Throwable $error) {
            var_dump($error);
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    final public function __set(string $name, $value): void {
        $this->model->{$name} = $value;
    }
}
