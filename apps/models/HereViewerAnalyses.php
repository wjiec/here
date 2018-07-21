<?php
/**
 * here_article_categories model
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Models;


use Phalcon\Mvc\Model;


/**
 * Class HereViewerAnalyses
 * @package Here\Models
 */
final class HereViewerAnalyses extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var integer
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
    public $view_url;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSchema("here");
        $this->setSource("here_viewer_analyses");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'here_viewer_analyses';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereViewerAnalyses[]|HereViewerAnalyses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereViewerAnalyses|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
