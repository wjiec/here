<?php
/**
 * INSERT HERE
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Theme_TemplateEngine_Syntax_Base
 */
abstract class Theme_TemplateEngine_Syntax_Base {
    /**
     * @var Theme_TemplateEngine_Engine
     */
    protected $_engine;

    /**
     * Theme_TemplateEngine_Syntax_Base constructor.
     * @param Theme_TemplateEngine_Engine $engine
     */
    final public function __construct(Theme_TemplateEngine_Engine &$engine) {
        $this->_engine = $engine;
    }

    /**
     * compile current syntax
     *
     * @return mixed
     */
    abstract public function compile();
}
