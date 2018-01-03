<?php
/**
 * HttpClient.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Http\Client;
use Here\Lib\Http\Client\Adapter\HttpAdapterInterface;


/**
 * Class HttpClient
 * @package Here\Lib\Http\Client
 */
final class HttpClient {
    /**
     * @var HttpAdapterInterface
     */
    private $_adapter;

    /**
     * Http constructor.
     * @param HttpAdapterInterface $adapter
     */
    final public function __construct(HttpAdapterInterface $adapter) {
        $this->_adapter = $adapter;
    }
}
