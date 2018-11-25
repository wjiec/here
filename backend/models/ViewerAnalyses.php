<?php
/**
 * Users.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Models;


use \Phalcon\Mvc\Model;


/**
 * Class ViewerAnalyses
 * @package Here\Models
 */
final class ViewerAnalyses extends Model {

    /**
     *
     * @var integer
     */
    public $viewer_id;

    /**
     *
     * @var string
     */
    public $viewer_ip_address;

    /**
     *
     * @var string
     */
    public $viewer_user_agent;

    /**
     *
     * @var string
     */
    public $viewer_view_page;

    /**
     *
     * @var string
     */
    public $viewer_referer;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('viewer_analyses');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'viewer_analyses';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ViewerAnalyses[]|ViewerAnalyses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ViewerAnalyses|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
