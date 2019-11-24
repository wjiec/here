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
namespace Here\Library\Mvc\Controller;

use Here\Library\Mvc\Component\Token;
use Phalcon\Cache\BackendInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter;


/**
 * Class AbstractController
 * @package Here\Library\Mvc\Controller
 * @property BackendInterface $cache
 */
abstract class AbstractController extends Controller {

    /**
     * Component of csrf generator/validator
     */
    use Token;

    /**
     * @var Adapter
     */
    protected $translator;

    /**
     * The controller setup was here
     */
    public function initialize() {
        $this->translator = container('translator');
    }

}
