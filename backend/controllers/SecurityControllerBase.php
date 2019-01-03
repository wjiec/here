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
use Here\Models\Authors;


/**
 * Class SecurityControllerBase
 * @package Here\controllers
 */
abstract class SecurityControllerBase extends ControllerBase {

    /**
     * check request signature
     */
    public function initialize() {
        // initializing property
        parent::initialize();
        // validate signature is correct
//        if (!$this->checkSignature()) {
//            $this->makeResponse(self::STATUS_SIGNATURE_INVALID,
//                $this->translator->SYS_SIGNATURE_INVALID);
//            $this->terminalByStatusCode(403);
//        }
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
            return Authors::findFirst() ?: null;
        }, RedisGetter::NO_EXPIRE);
    }

    /**
     * invalid request signature
     */
    private const STATUS_SIGNATURE_INVALID = 0xff00;

}
