<?php
/**
 * Base64Transform.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\RSA\Transform;


/**
 * Class Base64Transform
 * @package Here\Libraries\RSA\Transform
 */
final class Base64Transform implements TransformInterface {

    /**
     * @param array $input
     * @param string $glue
     * @return string
     */
    final public function forward(array $input, string $glue): string {
        return join($glue, array_map(function (string $segment): string {
            return base64_encode($segment);
        }, $input));
    }

    /**
     * @param string $input
     * @param string $glue
     * @return array
     */
    final public function backward(string $input, string $glue): array {
        return array_map(function (string $segment): string {
            return base64_decode($segment);
        }, explode($glue, $input));
    }

}
