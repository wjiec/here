<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Library\Validator\Adapter;

use Here\Library\Validator\ValidatorInterface;


/**
 * Class Inet
 * @package Here\Library\Validator\Adapter
 */
class Inet implements ValidatorInterface {

    /**
     * Execute the validation
     *
     * @param $data
     * @return bool
     */
    public function validate($data): bool {
        return filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6);
    }

}
