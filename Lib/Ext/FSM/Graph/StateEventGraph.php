<?php
/**
 * StateEventGraph.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\FSM\Graph;
use Here\Lib\Ext\FSM\Action\ActionInterface;
use Here\lib\Ext\FSM\Event\EventGenerator;
use Here\lib\Ext\FSM\Event\EventInterface;
use Here\Lib\Ext\FSM\State\StateInterface;


/**
 * Class StateEventGraph
 * @package Here\Lib\Ext\FSM\Graph
 */
final class StateEventGraph {
    /**
     * @var StateInterface[]
     */
    private $_states;

    /**
     * @var EventGenerator[]
     */
    private $_events;

    /**
     * @var ActionInterface[]
     */
    private $_actions;

    /**
     * StateEventGraph constructor.
     */
    final public function __construct() {
        $this->_states = array();
        $this->_events = array();
        $this->_actions = array();
    }

    /**
     * @param StateInterface[] ...$states
     */
    final public function set_states(StateInterface ...$states): void {
        $this->_states = $states;
    }

    /**
     * @param EventInterface[] ...$events
     */
    final public function set_events(EventInterface ...$events): void {
        $this->_events = $events;
    }

    /**
     * @param ActionInterface[] ...$actions
     * @return StateEventGraph
     * @throws ActionCountNotMatch
     * @throws TooMoreAction
     */
    final public function fill_action(ActionInterface ...$actions): self {
        if (count($this->_actions) === count($this->_events)) {
            throw new TooMoreAction("state-event graph is full");
        }

        if (count($actions) !== count($this->_states)) {
            throw new ActionCountNotMatch(
                sprintf("except %s action, but got {}", count($this->_states), count($actions)));
        }

        $this->_actions[] = $actions;
        return $this;
    }
}
