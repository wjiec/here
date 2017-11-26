<?php
/**
 * ActionInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\FSM\Action;
use Here\Lib\Ext\FSM\External\ExternalObjectInterface;
use Here\Lib\Ext\FSM\FiniteStateMachine;
use Here\Lib\Ext\FSM\State\StateInterface;


/**
 * Interface ActionInterface
 * @package Here\Lib\Ext\FSM\Action
 */
interface ActionInterface {
    /**
     * @param FiniteStateMachine $machine
     * @param ExternalObjectInterface|null $data
     * @return StateInterface
     */
    public static function run(FiniteStateMachine $machine, ?ExternalObjectInterface $data): StateInterface;
}
