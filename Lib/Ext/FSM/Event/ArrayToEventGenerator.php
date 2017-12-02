<?php
/**
 * ArrayToEventGenerator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\FSM\Event;


/**
 * Class ArrayToEventGenerator
 * @package Here\Lib\Ext\FSM\Event
 */
final class ArrayToEventGenerator implements EventGenerator {
    /**
     * ArrayToEventGenerator constructor.
     * @param array $inputs
     */
    final public function __construct(array $inputs) {
        var_dump($inputs); die();
    }

    /**
     * @return bool
     */
    final public function has_next(): bool {
        return true;
    }

    /**
     * @return EventInterface
     */
    final public function next(): EventInterface {
    }
}
