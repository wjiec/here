<?php
/**
 * HexTransform.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\RSA\Transform;


/**
 * Class HexTransform
 * @package Here\Libraries\RSA\Transform
 */
final class HexTransform implements TransformInterface {

    /**
     * @param array $input
     * @param string $glue
     * @return string
     */
    final public function forward(array $input, string $glue): string {
        return join($glue, array_map(function(string $segment): string {
            return bin2hex($segment);
        }, $input));
    }

    /**
     * @param string $input
     * @param string $glue
     * @return array
     */
    final public function backward(string $input, string $glue): array {
        return array_map(function (string $segment): string {
            return hex2bin($segment);
        }, explode($glue, $input));
    }

}
