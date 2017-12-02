<?php
/**
 * FiniteStateMachine.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\FSM;
use Here\Lib\Ext\FSM\Event\EventGenerator;
use Here\Lib\Ext\FSM\External\ExternalObjectInterface;
use Here\Lib\Ext\FSM\Graph\StateEventGraph;
use Here\Lib\Ext\FSM\State\StateInterface;


/**
 * Class FiniteStateMachine
 * @package Here\Lib\Ext\FSM
 */
final class FiniteStateMachine {
    /**
     * @var StateEventGraph
     */
    private $_graph;

    /**
     * @var StateInterface[]
     */
    private $_state_stack;

    /**
     * FiniteStateMachine constructor.
     * @param StateEventGraph $graph
     */
    final public function __construct(StateEventGraph $graph) {
        $this->_graph = $graph;
    }

    /**
     * @param EventGenerator $generator
     * @param StateInterface $start_state
     * @param ExternalObjectInterface|null $external_object
     */
    final public function run(EventGenerator $generator, StateInterface $start_state,
                              ?ExternalObjectInterface $external_object): void {
        $this->_state_stack = array($start_state);

        while ($generator->has_next()) {
            $event = $generator->next();
        }
    }
}
