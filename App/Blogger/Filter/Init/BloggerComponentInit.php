<?php
/**
 * BloggerComponentInit.php
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter\Init;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Stream\OStream\Client\OutputBuffer;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;


/**
 * Class BloggerComponentInit
 * @package Here\App\Blogger\Filter\Init
 */
final class BloggerComponentInit extends FilterChainProxyBase {
    /**
     * 1. startup output buffer
     * 2. register `ob` change callback
     */
    final public function do_filter(): void {
        /* output buffer startup */
        OutputBuffer::startup();
        /* listen all exception and error */
        GlobalExceptionHandler::error_trapping();

        /* exec next filter */
        $this->next();
    }
}
