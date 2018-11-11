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


use Here\Libraries\Signature\Context;


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
            $this->makeResponse(self::STATUS_SIGNATURE_INVALID, $this->translator->SYS_SIGNATURE_INVALID);
            $this->terminal(403);
        }
    }

    /**
     * @return bool
     */
    final private function checkSignature(): bool {
//        $this->signer_context = new Context();

        return true;
    }

    private const STATUS_SIGNATURE_INVALID = 0xff00;

}
