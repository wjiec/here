<?php
/**
 * en_US languages package
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Config\Languages;


use Phalcon\Config;


return new Config(array(
    'sys' => array(
        'signature' => array(
            'invalid' => 'invalid request'
        )
    ),
    'author' => array(
        'register' => array(
            'invalid' => 'Register information invalid, please refresh and try again',
            'incorrect' => 'Register information incorrect, please re-enter and try again',
            'welcome' => 'Register completed, Thanks for your support',
            'forbidden' => 'Prohibition of registration'
        )
    )
));
