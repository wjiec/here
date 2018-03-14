<?php
/**
 * AddHandlerCompiler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddHandler;
use Here\Config\Constant\SysConstant;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Http\HttpStatusCode;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;
use Here\Lib\Utils\Filter\Validator\TrueValidator;


/**
 * Class AddHandlerCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddHandler
 */
final class AddHandlerCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     * @throws UndefinedErrorCode
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxResultOverride
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_handler = new AddHandler();

        foreach ($value as $error_codes) {
            if (strpos($error_codes, SysConstant::ITEM_SEPARATOR) !== false) {
                $error_codes = explode(SysConstant::ITEM_SEPARATOR, $error_codes);
            } else {
                $error_codes = array($error_codes);
            }

            foreach ($error_codes as $error_code) {
                $error_code = trim($error_code);
                if (!HttpStatusCode::contains($error_code)) {
                    if (TrueValidator::filter(GlobalEnvironment::get_user_env('strict_router'))) {
                        throw new UndefinedErrorCode("[StrictMode]: ErrorCode(`{$error_code}`) undefined");
                    }
                }

                $add_handler->add_result($error_code);
            }
        }

        return $add_handler;
    }
}
