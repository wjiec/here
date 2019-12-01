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
 * Class Author
 * @package Here\Model
 */
final class Author extends AbstractModel {

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
     * @var string
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
    protected $last_login_time;

    /**
     *
     * @var string
     */
    protected $last_login_ip;

    /**
     * Method to set the value of field author_email
     *
     * @param string $author_email
     * @return $this
     */
    final public function setAuthorEmail(string $author_email) {
        $this->author_email = $author_email;
        return $this;
    }

    /**
     * Method to set the value of field author_username
     *
     * @param string $author_username
     * @return $this
     */
    final public function setAuthorUsername(string $author_username) {
        $this->author_username = $author_username;
        return $this;
    }

    /**
     * Method to set the value of field author_password
     *
     * @param string $author_password
     * @return $this
     */
    final public function setAuthorPassword(string $author_password) {
        $this->author_password = $author_password;
        return $this;
    }

    /**
     * Method to set the value of field author_nickname
     *
     * @param string $author_nickname
     * @return $this
     */
    final public function setAuthorNickname(string $author_nickname) {
        $this->author_nickname = $author_nickname;
        return $this;
    }

    /**
     * Method to set the value of field author_avatar
     *
     * @param string $author_avatar
     * @return $this
     */
    final public function setAuthorAvatar(string $author_avatar) {
        $this->author_avatar = $author_avatar;
        return $this;
    }

    /**
     * Method to set the value of field author_introduction
     *
     * @param string $author_introduction
     * @return $this
     */
    final public function setAuthorIntroduction(string $author_introduction) {
        $this->author_introduction = $author_introduction;
        return $this;
    }

    /**
     * Enabled 2fa for the author
     *
     * @param string $auth_code
     * @return $this
     */
    final public function enabledAuthorTwoFactorAuth(string $auth_code) {
        $this->author_2fa = self::BOOLEAN_TRUE;
        $this->author_2fa_code = $auth_code;
        return $this;
    }

    /**
     * Method to set the value of field last_login_time
     *
     * @param string $last_login_time
     * @return $this
     */
    final public function setLastLoginTime(string $last_login_time) {
        $this->last_login_time = $last_login_time;
        return $this;
    }

    /**
     * Method to set the value of field last_login_ip
     *
     * @param string $last_login_ip
     * @return $this
     */
    final public function setLastLoginIp(string $last_login_ip) {
        $this->last_login_ip = $last_login_ip;
        return $this;
    }

    /**
     * Returns the value of field author_id
     *
     * @return integer
     */
    final public function getAuthorId(): int {
        return (int)$this->author_id;
    }

    /**
     * Returns the value of field author_email
     *
     * @return string
     */
    final public function getAuthorEmail(): ?string {
        return $this->author_email;
    }

    /**
     * Returns the value of field author_username
     *
     * @return string
     */
    final public function getAuthorUsername(): ?string {
        return $this->author_username;
    }

    /**
     * Returns the value of field author_password
     *
     * @return string
     */
    final public function getAuthorPassword(): ?string {
        return $this->author_password;
    }

    /**
     * Returns the value of field author_nickname
     *
     * @return string
     */
    final public function getAuthorNickname(): ?string {
        return $this->author_nickname;
    }

    /**
     * Returns the value of field author_avatar
     *
     * @return string
     */
    final public function getAuthorAvatar(): ?string {
        return $this->author_avatar;
    }

    /**
     * Returns the value of field author_introduction
     *
     * @return string
     */
    final public function getAuthorIntroduction(): ?string {
        return $this->author_introduction;
    }

    /**
     * Returns is 2fa enabled of the author
     *
     * @return bool
     */
    final public function isEnabledAuthor2fa(): bool {
        return (int)$this->author_2fa === self::BOOLEAN_TRUE;
    }

    /**
     * Returns the value of field author_2fa_code
     *
     * @return string
     */
    final public function getAuthor2faCode(): ?string {
        return $this->author_2fa_code;
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
     * Returns the value of field update_time
     *
     * @return string
     */
    final public function getUpdateTime(): ?string {
        return $this->update_time;
    }

    /**
     * Returns the value of field last_login_time
     *
     * @return string
     */
    final public function getLastLoginTime(): ?string {
        return $this->last_login_time;
    }

    /**
     * Returns the value of field last_login_ip
     *
     * @return string
     */
    final public function getLastLoginIp(): ?string {
        return $this->last_login_ip;
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSource('author');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'author';
    }

    /**
     * Create new author by username and password
     *
     * @param string $username
     * @param string $password
     * @return $this
     */
    final public static function factory(string $username, string $password): self {
        $author = new static();
        $author->setAuthorUsername($username);
        $author->setAuthorNickname($username);
        $author->setAuthorPassword(password_hash($password, PASSWORD_DEFAULT));

        return $author;
    }

}
