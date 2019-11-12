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
namespace Here\Model;

use Here\Library\Mvc\Model\AbstractModel;


/**
 * Class Viewer
 * @package Here\Model
 */
final class Viewer extends AbstractModel {

    /**
     *
     * @var integer
     */
    protected $viewer_id;

    /**
     *
     * @var string
     */
    protected $viewer_key;

    /**
     *
     * @var string
     */
    protected $viewer_ip;

    /**
     *
     * @var integer
     */
    protected $viewer_stay_time;

    /**
     *
     * @var string
     */
    protected $viewer_user_agent;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     * Method to set the value of field viewer_key
     *
     * @param string $viewer_key
     * @return $this
     */
    final public function setViewerKey(string $viewer_key) {
        $this->viewer_key = $viewer_key;
        return $this;
    }

    /**
     * Method to set the value of field viewer_ip
     *
     * @param string $viewer_ip
     * @return $this
     */
    final public function setViewerIp(string $viewer_ip) {
        $this->viewer_ip = $viewer_ip;
        return $this;
    }

    /**
     * Method to set the value of field viewer_stay_time
     *
     * @param integer $viewer_stay_time
     * @return $this
     */
    final public function setViewerStayTime(int $viewer_stay_time) {
        $this->viewer_stay_time = $viewer_stay_time;
        return $this;
    }

    /**
     * Method to set the value of field viewer_user_agent
     *
     * @param string $viewer_user_agent
     * @return $this
     */
    final public function setViewerUserAgent(string $viewer_user_agent) {
        $this->viewer_user_agent = $viewer_user_agent;
        return $this;
    }

    /**
     * Returns the value of field viewer_id
     *
     * @return integer
     */
    final public function getViewerId(): int {
        return (int)$this->viewer_id;
    }

    /**
     * Returns the value of field viewer_key
     *
     * @return string
     */
    final public function getViewerKey(): ?string {
        return $this->viewer_key;
    }

    /**
     * Returns the value of field viewer_ip
     *
     * @return string
     */
    final public function getViewerIp(): ?string {
        return $this->viewer_ip;
    }

    /**
     * Returns the value of field viewer_stay_time
     *
     * @return integer
     */
    final public function getViewerStayTime(): int {
        return (int)$this->viewer_stay_time;
    }

    /**
     * Returns the value of field viewer_user_agent
     *
     * @return string
     */
    final public function getViewerUserAgent(): ?string {
        return $this->viewer_user_agent;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    final public function getCreateTime(): ?string {
        return $this->create_time;
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('viewer');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'viewer';
    }

}
