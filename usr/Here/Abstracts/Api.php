<?php
/**
 * Here Abstracts: Api
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Abstract: Api
 */
abstract class Here_Abstracts_Api {
    /**
     * Here_Abstracts_Api constructor.
     *
     * @param string $api_version
     * @throws Here_Exceptions_ApiError
     */
    public function __construct($api_version) {
        if ($api_version !== $this->_api_version) {
            throw new Here_Exceptions_ApiError("api version not match",
                'Here:Abstracts:Api:__construct');
        }
    }

    /**
     * current api name
     *
     * @var string
     */
    protected $_api_name;

    /**
     * getting current api name
     *
     * @return string
     */
    final public function get_api_name() {
        return $this->_api_name;
    }

    /**
     * current api version
     *
     * @var string
     */
    protected $_api_version;

    /**
     * getting current api version
     *
     * @return string
     */
    final public function get_api_version() {
        return $this->_api_version;
    }
}