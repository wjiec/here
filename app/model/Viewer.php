<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Mvc\Model;


/**
 * Class Viewer
 *
 * @package Here\Model
 */
class Viewer extends Model {

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
    public function setViewerKey(string $viewer_key) {
        $this->viewer_key = $viewer_key;
        return $this;
    }

    /**
     * Method to set the value of field viewer_ip
     *
     * @param string $viewer_ip
     * @return $this
     */
    public function setViewerIp(string $viewer_ip) {
        $this->viewer_ip = $viewer_ip;
        return $this;
    }

    /**
     * Method to set the value of field viewer_stay_time
     *
     * @param integer|string $viewer_stay_time
     * @return $this
     */
    public function setViewerStayTime(string $viewer_stay_time) {
        $this->viewer_stay_time = $viewer_stay_time;
        return $this;
    }

    /**
     * Method to set the value of field viewer_user_agent
     *
     * @param string $viewer_user_agent
     * @return $this
     */
    public function setViewerUserAgent(string $viewer_user_agent) {
        $this->viewer_user_agent = $viewer_user_agent;
        return $this;
    }

    /**
     * Returns the value of field viewer_id
     *
     * @return integer
     */
    public function getViewerId(): int {
        return (int)$this->viewer_id;
    }

    /**
     * Returns the value of field viewer_key
     *
     * @return string
     */
    public function getViewerKey(): ?string {
        return $this->viewer_key;
    }

    /**
     * Returns the value of field viewer_ip
     *
     * @return string
     */
    public function getViewerIp(): ?string {
        return $this->viewer_ip;
    }

    /**
     * Returns the value of field viewer_stay_time
     *
     * @return integer
     */
    public function getViewerStayTime(): int {
        return (int)$this->viewer_stay_time;
    }

    /**
     * Returns the value of field viewer_user_agent
     *
     * @return string
     */
    public function getViewerUserAgent(): ?string {
        return $this->viewer_user_agent;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    public function getCreateTime(): ?string {
        return $this->create_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('viewer');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'viewer';
    }

    /**
     * Create a new viewer
     *
     * @param string $key
     * @return static
     */
    public static function factory(string $key): self {
        $viewer = new static();
        $viewer->setViewerKey($key);

        return $viewer;
    }

}
