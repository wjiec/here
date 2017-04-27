<?php
/**
 * Here Db Utils: Expression
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Here_Db_Expression {
    private static $_symbol = array(
            'e'   => '=',
            'ne'  => '!=',
            'gt'  => '>',
            'gte' => '>=',
            'lt'  => '<',
            'lte' => '<='
    );

    private $_expression = null;

    public function __construct(array $expression) {
        $this->_expression = $expression;
    }

    public function expression($lcb = null, $rcb = null) {
        if (is_callable($lcb)) {
            $this->_expression['lval'] = call_user_func($lcb, $this->_expression['lval']);
        }
        if (is_callable($rcb)) {
            $this->_expression['rval'] = call_user_func($rcb, $this->_expression['rval']);
        }

        return $this->_expression;
    }

    public function lval($callback = null) {
        if (is_callable($callback)) {
            return call_user_func($callback, $this->_expression['lval']);
        }

        return $this->_expression['lval'];
    }

    public function rval($callback = null) {
        if (is_callable($callback)) {
            return call_user_func($callback, $this->_expression['rval']);
        }

        return $this->_expression['rval'];
    }

    public function operator() {
        return $this->_expression['operator'];
    }

    public static function symbol($e = '=', $ne = '!=', $gt = '>', $gte = '>=', $lt = '<', $lte = '<=') {
        return self::$_symbol = get_defined_vars();
    }

    /**
     * Expression: =
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function equal($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['e'], 'rval' => $right));
    }

    /**
     * Expression: !=
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function not_equal($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['ne'], 'rval' => $right));
    }

    /**
     * Expression: >
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function bigger_than($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['gt'], 'rval' => $right));
    }

    /**
     * Expression: >=
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function bigger_than_or_equal_to($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['gte'], 'rval' => $right));
    }

    /**
     * Expression: <
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function smaller_than($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['lt'], 'rval' => $right));
    }

    /**
     * Expression: <=
     *
     * @param string $left
     * @param string $right
     * @param string $variableType
     */
    public static function smaller_than_or_equal_to($left, $right, $variableType = 'ss') {
        list($left, $right) = self::multi_variable_check($variableType, $left, $right);

        return new Here_Db_Expression(array('lval' => $left, 'operator' => self::$_symbol['lte'], 'rval' => $right));
    }

    private static function multi_variable_check($variable_type) {
        $args = func_get_args();
        array_shift($args);

        if (is_string($variable_type) && count($args) === strlen($variable_type)) {
            $index = 0;
            foreach ($args as &$variable) {
                $variable = self::check_type($variable, $variable_type[$index++]);
            }
        } else {
            throw new \Exception('SDB: Expression: params not matched', 1996);
        }

        return $args;
    }

    /**
     * check variable type
     *
     * @param mixed $variable
     * @param string $type
     */
    private static function check_type($variable, $type) {
        if (is_string($type) && strlen($type) >= 1) {
            $type = substr($type, 0, 1);
        }

        switch ($type) {
            case 's': return is_string($variable) ?$variable : strval($variable); break;
            case 'i': return is_int($variable) ? $variable : intval($variable); break;
            case 'f': return is_float($variable) ? $variable : floatval($variable); break;
            case 'd': return is_double($variable) ? $variable : doubleval($variable); break;
            case 'b': return is_bool($variable) ? $variable : boolval($variable); break;
            case 'm': return $variable;
            default: throw new \Exception('SDB: Expression: unknown variable type for \'' . $type . '\'', 1996);
        }
    }
}
