<?php
/**
 * EventGenerator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\lib\Ext\FSM\Event;


/**
 * Interface EventGenerator
 * @package Here\lib\Ext\FSM\Event
 */
interface EventGenerator {
    /**
     * @return EventInterface
     */
    public function next(): EventInterface;

    /**
     * @return bool
     */
    public function has_next(): bool;
}
