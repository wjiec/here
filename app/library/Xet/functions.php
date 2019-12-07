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
namespace Here\Library\Xet;


if (!function_exists('current_date')) {
    /**
     * Gets the date string current
     *
     * @return string
     */
    function current_date() {
        return date('Y-m-d H:i:s');
    }
}
