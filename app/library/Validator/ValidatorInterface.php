<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Validator;


/**
 * Interface ValidatorInterface
 * @package Here\Library\Validator
 */
interface ValidatorInterface {

    /**
     * Execute the validation
     *
     * @param $data
     * @return bool
     */
    public function validate($data): bool;

}
