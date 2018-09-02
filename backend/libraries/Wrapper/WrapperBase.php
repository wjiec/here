<?php
/**
 * WrapperBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\Wrapper;


use Phalcon\Config;
use Phalcon\Di;


/**
 * Class WrapperBase
 * @package Here\Libraries\Wrapper
 */
abstract class WrapperBase implements WrapperInterface {

    /**
     * @var Config
     */
    protected $config;

    /**
     * WrapperBase constructor.
     */
    public function __construct() {
        $this->config = Di::getDefault()->get('config');
    }

}
