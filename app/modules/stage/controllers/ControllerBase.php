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
namespace Here\Stage\Controllers;

use Phalcon\Config;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;


/**
 * Class ControllerBase
 * @package Here\Stage\Controllers
 * @property Config $config
 * @property Tag $tag
 */
abstract class ControllerBase extends Controller {}
