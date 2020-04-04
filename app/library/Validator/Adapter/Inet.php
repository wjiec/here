<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
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
