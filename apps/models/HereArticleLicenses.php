<?php
/**
 * here_article_licenses model
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Models;


use Phalcon\Mvc\Model;


/**
 * Class HereArticleLicenses
 * @package Here\Backend\Models
 */
final class HereArticleLicenses extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var string
     */
    public $license_name;

    /**
     *
     * @var string
     */
    public $license_icon;

    /**
     *
     * @var string
     */
    public $license_dispaly;

    /**
     *
     * @var string
     */
    public $license_contents;

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSchema("here");
        $this->setSource("here_article_licenses");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'here_licenses';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticleLicenses[]|HereArticleLicenses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticleLicenses|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
