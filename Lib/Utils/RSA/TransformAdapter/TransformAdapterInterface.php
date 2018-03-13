<?php
/**
 * Base64Adapter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\RSA\TransformAdapter;


/**
 * Interface OutputAdapterInterface
 * @package Lib\Utils\RSA\OutputAdapter
 */
interface TransformAdapterInterface {
    /**
     * @param array $input
     * @param string $glue
     * @return string
     */
    public function transform_forward(array $input, string $glue): string;

    /**
     * @param string $input
     * @param string $glue
     * @return array
     */
    public function transform_backward(string $input, string $glue): array;
}
