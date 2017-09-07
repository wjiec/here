<?php
/**
 * Http.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Http;
use Here\Lib\Abstracts\HttpAdapterBase;


/**
 * Class Http
 * @package Here\Lib\Http
 */
class Http {
    /**
     * @var HttpAdapterBase
     */
    private $_adapter;

    /**
     * Http constructor.
     * @param HttpAdapterBase $adapter
     */
    final public function __construct(HttpAdapterBase $adapter) {
        $this->_adapter = $adapter;
    }
}
