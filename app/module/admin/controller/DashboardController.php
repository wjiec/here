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
namespace Here\Admin\Controller;

use Here\Provider\Field\Store\Adapter\Mixed;
use Phalcon\Mvc\Controller;


/**
 * Class DashboardController
 * @package Here\Admin\Controller
 */
final class DashboardController extends Controller {

    /**
     * Shows the dashboard to the admin of blog
     */
    final public function indexAction() {
        /* @var Mixed $field */
        $field = container('field');
        var_dump($field->get('admin.prefix'));
        var_dump($field); die();
    }

}
