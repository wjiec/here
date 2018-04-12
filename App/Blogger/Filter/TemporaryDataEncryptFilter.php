<?php
/**
 * TemporaryDataEncryptFilter.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter;
use Here\Lib\Cache\Data\DataType\String\StringValue;
use Here\Lib\Config\ConfigRepository;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Utils\RSA\RSAObject;


/**
 * Class TemporaryDataEncryptFilter
 *
 * @package Here\App\Blogger\Filter
 */
final class TemporaryDataEncryptFilter extends FilterChainProxyBase {
    /**
     * create new RSA-key when redis cannot found
     */
    final public function do_filter(): void {
        $rsa = new StringValue('security:rsa');
        if (!$rsa->get_value()) {
            $rsa->assign(RSAObject::generate()->get_private_key());
            $rsa->set_expire(ConfigRepository::get_item('security.rsa.time_limit'));
        }

        $this->next();
    }
}
