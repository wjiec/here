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
            'invalid' => '无效的请求'
        )
    ),
    'author' => array(
        'register' => array(
            'invalid' => '注册信息无效, 请刷新重试',
            'incorrect' => '注册信息错误, 请重新输入',
            'welcome' => '注册完成, 感谢您的使用',
            'forbidden' => '禁止注册'
        )
    )
));
