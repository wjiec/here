<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Wizard;

use Here\Model\Author;
use Phalcon\Cache\BackendInterface;


/**
 * Class SetupWizard
 * @package Here\Provider\Wizard
 */
final class SetupWizard {

    /**
     * @var BackendInterface
     */
    protected $cache;

    /**
     * Name of the wizard redis cache
     *
     * @var string
     */
    protected $wizard_key = 'wizard';

    /**
     * Create SetupWizard
     */
    final public function __construct() {
        $this->cache = container('cache');
    }

    /**
     * Checks the application has initialized
     *
     * @return bool
     */
    final public function isInitialized(): bool {
        if ($this->cache->exists($this->wizard_key)) {
            return true;
        }
        return !!Author::findFirst();
    }

}
