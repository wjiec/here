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
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;


/**
 * Class Users
 * @package Here\Models
 */
final class Users extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $nickname;

    /**
     *
     * @var string
     */
    public $user_avatar;

    /**
     *
     * @var string
     */
    public $user_introduction;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $last_login_time;

    /**
     *
     * @var integer
     */
    public $last_login_ip_address;

    /**
     *
     * @var integer
     */
    public $two_factor_auth;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    final public function validation() {
        $validator = new Validation();

        $validator->add('email', new EmailValidator(array(
            'model'   => $this,
            'message' => 'Please enter a correct email address',
        )));

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    final public function initialize() {
        $this->setSchema("here");
        $this->setSource("users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
