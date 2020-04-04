<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Welcome;


use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class Welcome
 * @package Here\Provider\Welcome
 */
class Welcome {

    /**
     * @var DateTime
     */
    protected $datetime;

    /**
     * @var DateTimeZone
     */
    protected $timezone;

    /**
     * Welcome constructor.
     * @param string $timezone
     * @throws Exception
     */
    public function __construct(string $timezone) {
        $this->timezone = new DateTimeZone($timezone);
        $this->datetime = new DateTime('now', $this->timezone);
    }

    /**
     * Say welcome
     *
     * @return string
     */
    public function say(): string {
        $hour = $this->datetime->format('H');
        switch (true) {
            case $hour >= 6 && $hour < 11:
                return _t('welcome_morning');
            case $hour >= 11 && $hour < 13:
                return _t('welcome_noon');
            case $hour >= 13 && $hour < 18:
                return _t('welcome_afternoon');
            case $hour >= 18 && $hour < 23:
                return _t('welcome_night');
            default:
                return _t('welcome_midnight');
        }
    }

}
