<?php
/**
 * WrapperInterface.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\Wrapper;


/**
 * Interface WrapperInterface
 * @package Here\Libraries\Wrapper
 */
interface WrapperInterface {

    /**
     * @param bool $force
     * @return mixed
     */
    public function get(bool $force = false);

}
