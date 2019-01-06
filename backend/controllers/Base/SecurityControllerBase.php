<?php
/**
 * SecurityControllerBase.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Controllers\Base;


use Here\Libraries\Signature\Context;
use Here\Libraries\Signature\SignatureException;


/**
 * Class SecurityControllerBase
 * @package Here\controllers
 */
abstract class SecurityControllerBase extends AuthorControllerBase {

    /**
     * @var Context
     */
    private $context;

    /**
     * check request signature
     */
    public function initialize() {
        // initializing property
        parent::initialize();

        // factory context from session
        try {
            $this->context = Context::factoryFromSession();
        } catch (SignatureException $e) {
            $this->makeResponse(self::STATUS_SIGNATURE_INVALID, $this->t->_('signature_invalid'));
            $this->terminalByStatusCode(403);
        }
    }

    /**
     * invalid request signature
     */
    private const STATUS_SIGNATURE_INVALID = 0xff00;

}
