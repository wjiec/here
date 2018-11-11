<?php
/**
 * WrapperBase.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
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
