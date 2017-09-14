<?php
/**
 * IoFilterBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter;


/**
 * Class IoFilterBase
 * @package Here\Lib\Io\Filter
 */
abstract class IoFilterBase implements IoFilterInterface {
    /**
     * @var array
     */
    private $_filter_chain;

    /**
     * IoFilterBase constructor.
     */
    final public function __construct() {
        $this->_filter_chain = array();
    }

    /**
     * @param mixed $object
     * @param null $default
     * @return mixed|null
     */
    final public function apply($object, $default = null) {
        return null;
    }
}
