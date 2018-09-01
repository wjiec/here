<?php
/**
 * TransformInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\RSA\Transform;


/**
 * Interface TransformInterface
 * @package Here\Libraries\RSA\Transform
 */
interface TransformInterface {

    /**
     * @param array $input
     * @param string $glue
     * @return string
     */
    public function forward(array $input, string $glue): string;

    /**
     * @param string $input
     * @param string $glue
     * @return array
     */
    public function backward(string $input, string $glue): array;

}
