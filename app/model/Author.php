<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Mvc\Model;


/**
 * Class Author
 *
 * @package Here\Model
 */
class Author extends Model {

    /**
     *
     * @var integer
     */
    protected $author_id;

    /**
     *
     * @var string
     */
    protected $author_email;

    /**
     *
     * @var string
     */
    protected $author_username;

    /**
     *
     * @var string
     */
    protected $author_password;

    /**
     *
     * @var string
     */
    protected $author_nickname;

    /**
     *
     * @var string
     */
    protected $author_avatar;

    /**
     *
     * @var string
     */
    protected $author_introduction;

    /**
     *
     * @var bool
     */
    protected $author_2fa;

    /**
     *
     * @var string
     */
    protected $author_2fa_code;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     *
     * @var string
     */
    protected $update_time;

    /**
     *
     * @var string
     */
    protected $last_login_ip;

    /**
     *
     * @var string
     */
    protected $last_login_time;

    /**
     * Method to set the value of field author_email
     *
     * @param string $author_email
     * @return $this
     */
    public function setAuthorEmail(string $author_email) {
        $this->author_email = $author_email;

        return $this;
    }

    /**
     * Method to set the value of field author_username
     *
     * @param string $author_username
     * @return $this
     */
    public function setAuthorUsername(string $author_username) {
        $this->author_username = $author_username;

        return $this;
    }

    /**
     * Method to set the value of field author_password
     *
     * @param string $author_password
     * @return $this
     */
    public function setAuthorPassword(string $author_password) {
        $this->author_password = $author_password;

        return $this;
    }

    /**
     * Method to set the value of field author_nickname
     *
     * @param string $author_nickname
     * @return $this
     */
    public function setAuthorNickname(string $author_nickname) {
        $this->author_nickname = $author_nickname;

        return $this;
    }

    /**
     * Method to set the value of field author_avatar
     *
     * @param string $author_avatar
     * @return $this
     */
    public function setAuthorAvatar(string $author_avatar) {
        $this->author_avatar = $author_avatar;

        return $this;
    }

    /**
     * Method to set the value of field author_introduction
     *
     * @param string $author_introduction
     * @return $this
     */
    public function setAuthorIntroduction(string $author_introduction) {
        $this->author_introduction = $author_introduction;

        return $this;
    }

    /**
     * Method to set the value of field author_2fa
     *
     * @param bool $author_2fa
     * @return $this
     */
    public function setAuthor2fa(bool $author_2fa) {
        $this->author_2fa = $author_2fa;

        return $this;
    }

    /**
     * Method to set the value of field author_2fa_code
     *
     * @param string $author_2fa_code
     * @return $this
     */
    public function setAuthor2faCode(string $author_2fa_code) {
        $this->author_2fa_code = $author_2fa_code;

        return $this;
    }

    /**
     * Method to set the value of field update_time
     *
     * @param string $update_time
     * @return $this
     */
    public function setUpdateTime(string $update_time) {
        $this->update_time = $update_time;

        return $this;
    }

    /**
     * Method to set the value of field last_login_ip
     *
     * @param string $last_login_ip
     * @return $this
     */
    public function setLastLoginIp(string $last_login_ip) {
        $this->last_login_ip = $last_login_ip;

        return $this;
    }

    /**
     * Method to set the value of field last_login_time
     *
     * @param string $last_login_time
     * @return $this
     */
    public function setLastLoginTime(string $last_login_time) {
        $this->last_login_time = $last_login_time;

        return $this;
    }

    /**
     * Returns the value of field author_id
     *
     * @return integer
     */
    public function getAuthorId() {
        return (int)$this->author_id;
    }

    /**
     * Returns the value of field author_email
     *
     * @return string
     */
    public function getAuthorEmail() {
        return $this->author_email;
    }

    /**
     * Returns the value of field author_username
     *
     * @return string
     */
    public function getAuthorUsername() {
        return $this->author_username;
    }

    /**
     * Returns the value of field author_password
     *
     * @return string
     */
    public function getAuthorPassword() {
        return $this->author_password;
    }

    /**
     * Returns the value of field author_nickname
     *
     * @return string
     */
    public function getAuthorNickname() {
        return $this->author_nickname;
    }

    /**
     * Returns the value of field author_avatar
     *
     * @return string
     */
    public function getAuthorAvatar() {
        return $this->author_avatar;
    }

    /**
     * Returns the value of field author_introduction
     *
     * @return string
     */
    public function getAuthorIntroduction() {
        return $this->author_introduction;
    }

    /**
     * Returns the value of field author_2fa
     *
     * @return bool
     */
    public function getAuthor2fa() {
        return $this->author_2fa;
    }

    /**
     * Returns the value of field author_2fa_code
     *
     * @return string
     */
    public function getAuthor2faCode() {
        return $this->author_2fa_code;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    public function getCreateTime() {
        return $this->create_time;
    }

    /**
     * Returns the value of field update_time
     *
     * @return string
     */
    public function getUpdateTime() {
        return $this->update_time;
    }

    /**
     * Returns the value of field last_login_ip
     *
     * @return string
     */
    public function getLastLoginIp() {
        return $this->last_login_ip;
    }

    /**
     * Returns the value of field last_login_time
     *
     * @return string
     */
    public function getLastLoginTime() {
        return $this->last_login_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('author');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'author';
    }

}
