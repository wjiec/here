<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Libraries\Listener;

use Phalcon\DiInterface;
use Phalcon\Mvc\User\Component;


/**
 * Class AbstractListener
 * @package Here\Libraries\Listener
 */
abstract class AbstractListener extends Component {

    /**
     * AbstractListener constructor.
     * @param DiInterface|null $di
     */
    public function __construct(DiInterface $di = null) {
        $this->setDI($di ?? container());
    }

}
