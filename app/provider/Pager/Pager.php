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
namespace Here\Provider\Pager;


/**
 * Class Pager
 * @package Here\Provider\Pager
 */
class Pager {

    /**
     * Number of the current page
     *
     * @var int
     */
    protected $current;

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
     * @param int $current
     * @param int $size
     * @param int $total
     */
    public function __construct(int $current, int $size, int $total) {
        $this->current = $current;
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
     * Returns a url string mean to `index` page
     *
     * @param int $index
     * @return string
     */
    public function getUrl(int $index): string {
        if ($index <= 0) {
            $index = 1;
        } else if ($index > $this->getTotal()) {
            $index = $this->getTotal();
        }

        return str_replace('{:page:}', $index, $this->template);
    }

    /**
     * Returns the url string to prev page
     *
     * @return string
     */
    public function getPrevUrl(): string {
        return $this->getUrl($this->current - 1);
    }

    /**
     * Returns true when previous page exists
     *
     * @return bool
     */
    public function hasPrev(): bool {
        return $this->current !== 1;
    }

    /**
     * Returns the url string to next page
     *
     * @return string
     */
    public function getNextUrl(): string {
        return $this->getUrl($this->current + 1);
    }

    /**
     * Returns true when previous page exists
     *
     * @return bool
     */
    public function hasNext(): bool {
        return $this->current !== $this->getTotal();
    }

    /**
     * Returns the number of the current index
     *
     * @return int
     */
    public function getCurrent(): int {
        return $this->current;
    }

    /**
     * Returns an url string with prev turn
     *
     * @return bool
     */
    public function hasPrevTurn(): bool {
        return $this->current > self::PREV_PAGER_COUNT + 1;
    }

    /**
     * Returns an url string with prev turn
     *
     * @return string
     */
    public function getPrevTurnUrl(): string {
        return $this->getUrl($this->current - self::PREV_PAGER_COUNT - self::NEXT_PAGER_COUNT - 1);
    }

    /**
     * Returns an url string with next turn
     *
     * @return bool
     */
    public function hasNextTurn(): bool {
        return $this->current < $this->getTotal() - self::NEXT_PAGER_COUNT;
    }

    /**
     * Returns an url string with next turn
     *
     * @return string
     */
    public function getNextTurnUrl(): string {
        return $this->getUrl($this->current + self::PREV_PAGER_COUNT + self::NEXT_PAGER_COUNT + 1);
    }

    /**
     * Returns the number of the iterator start at
     *
     * @return int
     */
    public function getPagerIteratorStart(): int {
        return min(max($this->current - self::PREV_PAGER_COUNT, 1), $this->getTotal());
    }

    /**
     * Returns the number of the iterator end on
     *
     * @return int
     */
    public function getPagerIteratorEnd(): int {
        return min($this->current + self::NEXT_PAGER_COUNT, $this->getTotal());
    }

    /**
     * Returns the iterator of the pager
     *
     * @return array
     */
    public function getPagerIterator(): array {
        $start = $this->getPagerIteratorStart();
        $end = $this->getPagerIteratorEnd();

        return array_map(function() use (&$start) {
            return $start++;
        }, array_fill(0, $end - $start + 1, 0));
    }

    /**
     * Returns the number of the page total
     *
     * @return int
     */
    public function getTotal(): int {
        $count = $this->total / $this->size;
        return is_float($count) ? ((int)$count + 1) : $count;
    }

    /**
     * @const PREV_PAGER_COUNT The number of the to previous count
     */
    protected const PREV_PAGER_COUNT = 3;

    /**
     * @const NEXT_PAGER_COUNT The number of the to next count
     */
    protected const NEXT_PAGER_COUNT = 3;

}
