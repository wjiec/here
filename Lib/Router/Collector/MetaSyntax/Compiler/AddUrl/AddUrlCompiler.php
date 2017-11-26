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
use Here\lib\Ext\FSM\Event\EventGenerator;
use Here\Lib\Ext\FSM\FiniteStateMachine;
use Here\Lib\Ext\FSM\Graph\StateEventGraph;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\NamedPathState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\OptionalPathEndState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\OptionalPathStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\ParseEndState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\ParseStartState;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\State\RegexPathEndState;
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
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $fsm = self::get_syntax_fsm();
        $add_url_component = new AddUrl();

        foreach ($value as $url_rule) {
            var_dump(sprintf("%s", htmlentities($url_rule)));
            // $fsm->run(self::get_event_generator($url_rule));
        }

        return $add_url_component;
    }

    /**
     * @return FiniteStateMachine
     */
    final private static function get_syntax_fsm(): FiniteStateMachine {
        return new FiniteStateMachine(self::get_state_event_graph());
    }

    /**
     * @param string $url
     * @return EventGenerator
     */
    final private static function get_event_generator(string $url): EventGenerator {
    }

    /**
     * @return StateEventGraph
     */
    final private static function get_state_event_graph(): StateEventGraph {
        $graph = new StateEventGraph();

        // states
        $parse_start = new ParseStartState();
        $parse_end = new ParseEndState();
        $scalar_path = new ScalarPathState();
        $var_start = new VariablePathStartState();
        $var_end = new VariablePathEndState();
        $opt_start = new OptionalPathStartState();
        $opt_end = new OptionalPathEndState();
        $named_path = new NamedPathState();
        $reg_start = new RegexPathStartState();
        $reg_end = new RegexPathEndState();

        // event

        $graph->set_states($parse_start, $scalar_path, $var_start, $var_end, $opt_start, $opt_end, $named_path, $reg_start, $reg_end, $parse_end);
        $graph->set_events();
//        $graph/* ParseStart ScalarPath VariablePathStart VariablePathEnd OptionalPathStart OptionalPathEnd NamedPath RegexPathStart RegexPathEnd ParseEnd */
//        /* Event */->fill_action()
//        /* Event */->fill_action()
//        /* Event */->fill_action()
//        /* Event */->fill_action()
//        /* Event */->fill_action()
//        /* Event */->fill_action()
//        ;
        return $graph;
    }
}
