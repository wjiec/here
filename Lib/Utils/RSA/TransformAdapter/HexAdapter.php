<?php
/**
 * HexAdapter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\RSA\TransformAdapter;


/**
 * Class HexAdapter
 * @package Here\Lib\Utils\RSA\TransformAdapter
 */
final class HexAdapter implements TransformAdapterInterface {
    /**
     * @param array $input
     * @param string $glue
     * @return string
     */
    final public function transform_forward(array $input, string $glue): string {
        return join($glue, array_map(function(string $segment): string {
            return bin2hex($segment);
        }, $input));
    }

    /**
     * @param string $input
     * @param string $glue
     * @return array
     */
    final public function transform_backward(string $input, string $glue): array {
        return array_map(function (string $segment): string {
            return hex2bin($segment);
        }, explode($glue, $input));
    }
}
