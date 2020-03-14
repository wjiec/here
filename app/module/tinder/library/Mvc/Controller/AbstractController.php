<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Library\Mvc\Controller;

use Here\Library\Mvc\Controller\AbstractController as MvcAbstractController;


/**
 * Class AbstractController
 * @package Here\Tinder\Library\Mvc\Controller
 */
abstract class AbstractController extends MvcAbstractController {

    /**
     * @const ARTICLES_IN_PAGE The number of the articles per page
     */
    protected const ARTICLES_IN_PAGE = 10;

}
