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
namespace Here\Provider\Color;


/**
 * Class ColorWheel
 * @package Here\Provider\Color
 */
class ColorWheel {

    /**
     * @var string[]
     */
    protected $colors;

    /**
     * ColorWheel constructor.
     * @param array $colors
     */
    public function __construct(array $colors) {
        $this->colors = $colors;
    }

    /**
     * Returns the color value by randomly
     *
     * @return string
     */
    public function random(): string {
        return $this->colors[mt_rand(0, count($this->colors) - 1)];
    }

}
