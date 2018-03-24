<?php
/**
 * AutoCommitFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Stream\OStream\Client\OutputBuffer;


/**
 * Class AutoCommitFilter
 * @package Here\App\Blogger\Filter
 */
final class AutoCommitFilter extends FilterChainProxyBase {
    /**
     * auto commit response
     */
    public function do_filter(): void {
        /* run next filter */
        $this->next();

        /* commit response to client */
        OutputBuffer::commit_buffer();
    }
}
