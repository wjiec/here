<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Avatar;


use Phalcon\Mvc\Url;

/**
 * Class Avatar
 * @package Here\Provider\Avatar
 */
class Avatar {

    /**
     * Paths of the avatar
     *
     * @var string
     */
    protected $default = '/assets/avatar/default.webp';

    /**
     * Returns string of the avatar
     *
     * @param string $default
     * @return string
     */
    public function getUrl(string $default): string {
        return $default ?: container('url')->getStatic($this->default);
    }

}
