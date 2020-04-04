<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
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
