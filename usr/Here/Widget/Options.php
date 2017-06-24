<?php
/**
 * Here Widget: Options
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget_Options extends Here_Abstracts_Widget {
    public function __construct(array $options) {
        parent::__construct($options);

        if (!is_file(_here_user_configure_)) {
            return;
        }

        # TODO. from database fetch options
    }
}

