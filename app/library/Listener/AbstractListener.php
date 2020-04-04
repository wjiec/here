<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Listener;

use Phalcon\DiInterface;
use Phalcon\Mvc\User\Component;


/**
 * Class AbstractListener
 * @package Here\Library\Listener
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
