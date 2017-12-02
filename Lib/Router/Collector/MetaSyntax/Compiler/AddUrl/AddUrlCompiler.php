<?php
/**
 * AddUrlCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Ext\FSM\Event\ArrayToEventGenerator;
use Here\Lib\Ext\FSM\Event\EventGenerator;
use Here\Lib\Ext\FSM\FiniteStateMachine;
use Here\Lib\Ext\FSM\Graph\StateEventGraph;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\EofCharEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\OptionalPathEndEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\OptionalPathStartEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\RegexPathEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\ScalarCharEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\UrlSeparatorEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\VariablePathEndEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Event\VariablePathStartEvent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\NamedPathState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\OptionalPathEndState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\OptionalPathStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\ParseEndState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\ParseStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\RegexPathState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\RegexPathStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\ScalarPathState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\VariablePathEndState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\VariablePathStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class AddUrlCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class AddUrlCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     * @throws \Here\Lib\Ext\FSM\Graph\ActionCountNotMatch
     * @throws \Here\Lib\Ext\FSM\Graph\TooMoreAction
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $fsm = self::get_syntax_fsm();
        $add_url_component = new AddUrl();

        foreach ($value as $url_rule) {
            var_dump(sprintf("%s", htmlentities($url_rule)));
             $fsm->run(self::get_event_generator($url_rule), new ParseStartState(), null);
        }

        return $add_url_component;
    }

    /**
     * @return FiniteStateMachine
     * @throws \Here\Lib\Ext\FSM\Graph\ActionCountNotMatch
     * @throws \Here\Lib\Ext\FSM\Graph\TooMoreAction
     */
    final private static function get_syntax_fsm(): FiniteStateMachine {
        return new FiniteStateMachine(self::get_state_event_graph());
    }

    /**
     * @param string $url
     * @return EventGenerator
     */
    final private static function get_event_generator(string $url): EventGenerator {
        return new ArrayToEventGenerator(
            array_merge(str_split($url), array("\0"))
        );
    }

    /**
     * @return StateEventGraph
     * @throws \Here\Lib\Ext\FSM\Graph\ActionCountNotMatch
     * @throws \Here\Lib\Ext\FSM\Graph\TooMoreAction
     */
    final private static function get_state_event_graph(): StateEventGraph {
        $graph = new StateEventGraph();

        // states
        $graph->set_states(
            new ParseStartState(), new ScalarPathState(),  // scalar path
            new VariablePathStartState(), new VariablePathEndState(),  // variable path
            new OptionalPathStartState(), new OptionalPathEndState(),  // optional path
            new NamedPathState(),  // named path
            new RegexPathStartState(), new RegexPathState() // regex mode
        );

        // events
        $graph->set_events(
            new ScalarCharEvent(), new UrlSeparatorEvent(),  // scalar char ot utl separator
            new VariablePathStartEvent(), new VariablePathEndEvent(),  // variable path
            new OptionalPathStartEvent(), new OptionalPathEndEvent(),  // optional path
            new RegexPathEvent(),
            new EofCharEvent()
        );

        $sep = 'Separator Action';
        $kps = 'Keep State';
        $chk = 'Multi Check Cond';
        $nnd = 'Named Node';
        $gVS = 'Go to varS';
        $gVE = 'Go to varE';
        $gOS = 'Go to optS';
        $gOE = 'Go to optE';
        $end = "success exit";
        $reS = 'Regex Start';
        $mVE = "maybe varE";
        $mOE = "maybe optE";
        $reg = "regex pattern";
        $cPC = "check previous character";

        $graph/*                                          start scalar varS  varE  optS  optE  name  regS  regex */
        /* ScalarCharEvent         */->fill_action(NULL, $kps, $nnd, NULL, $nnd, NULL, $kps, $reg, $reg)
        /* UrlSeparatorEvent       */->fill_action($sep, $sep, NULL, $sep, NULL, $sep, NULL, $cPC, $sep)
        /* VariablePathStartEvent  */->fill_action(NULL, $gVS, NULL, NULL, NULL, NULL, NULL, $cPC, $cPC)
        /* VariablePathEndEvent    */->fill_action(NULL, NULL, NULL, NULL, NULL, NULL, $gVE, $mVE, $mVE)
        /* OptionalPathStartEvent  */->fill_action(NULL, $gOS, NULL, NULL, NULL, NULL, NULL, $cPC, $cPC)
        /* OptionalPathEndEvent    */->fill_action(NULL, NULL, NULL, NULL, NULL, NULL, $gOE, $mOE, $mOE)
        /* RegexPathEvent          */->fill_action(NULL, $chk, $reS, NULL, $reS, NULL, $reS, $cPC, $cPC)
        /* EofCharEvent            */->fill_action(NULL, $end, NULL, $end, NULL, $end, NULL, NULL, NULL)
        ;
        return $graph;
    }
}
