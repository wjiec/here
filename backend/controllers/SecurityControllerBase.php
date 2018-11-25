<?php
/**
 * SecurityControllerBase.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers;


use Here\Libraries\Redis\RedisGetter;
use Here\Libraries\Redis\RedisKeys;
use Here\Libraries\RSA\RSAObject;
use Here\Libraries\Signature\Context;
use Here\Models\Authors;


/**
 * Class SecurityControllerBase
 * @package Here\controllers
 */
abstract class SecurityControllerBase extends ControllerBase {

    /**
     * @var Context
     */
    private $signer_context;

    /**
     * check request signature
     */
    public function initialize() {
        parent::initialize();

        // validate sign
        if (!$this->checkSignature()) {
            $this->makeResponse(self::STATUS_SIGNATURE_INVALID,
                $this->translator->SYS_SIGNATURE_INVALID);
            $this->terminalByStatusCode(403);
        }
    }

    /**
     * @return bool
     */
    final private function checkSignature(): bool {
//        $this->signer_context = new Context();

        return true;
    }

    /**
     * @return RSAObject
     */
    final protected function getCachedRSAObject(): RSAObject {
        return (new RedisGetter())->get(RedisKeys::getRSAPrivateRedisKey(), function() {
            return RSAObject::generate(1024);
        }, RedisGetter::EXPIRE_ONE_DAY);
    }

    /**
     * @return Authors|null
     */
    final protected function getCachedAuthor(): ?Authors {
        return (new RedisGetter())->get(RedisKeys::getAuthorRedisKey(), function() {
            $user = Authors::findFirst();
            return $user ?: null;
        }, RedisGetter::NO_EXPIRE);
    }

    private const STATUS_SIGNATURE_INVALID = 0xff00;

}
