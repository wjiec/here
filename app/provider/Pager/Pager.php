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
namespace Here\Provider\Pager;


/**
 * Class Pager
 * @package Here\Provider\Pager
 */
class Pager {

    /**
     * Number of the per page
     *
     * @var int
     */
    protected $size;

    /**
     * The number of the model total
     *
     * @var int
     */
    protected $total;

    /**
     * Template of the pagination url
     *
     * @var string
     */
    protected $template;

    /**
     * Pager constructor.
     * @param int $size
     * @param int $total
     */
    public function __construct(int $size, int $total) {
        $this->size = $size;
        $this->total = $total;
    }

    /**
     * Sets the template of the pagination url
     *
     * @param string $template
     * @return Pager
     */
    public function setTemplate(string $template): Pager {
        $this->template = $template;
        return $this;
    }

    /**
     * Render the contents of pagination
     *
     * @param string $template
     * @return string
     */
    public function render(string $template): string {
        $template = str_replace( '{:url}', $this->template, $template);
        $template = str_replace( '{:page}', 2, $template);
        return str_repeat($template, $this->size);
    }

}
