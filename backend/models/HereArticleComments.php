<?php
/**
 * here_article_comments model
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Models;


use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;


/**
 * Class HereArticleComments
 * @package Here\Backend\Models
 */
final class HereArticleComments extends Model {

    /**
     *
     * @var integer
     */
    public $serial_id;

    /**
     *
     * @var integer
     */
    public $article_id;

    /**
     *
     * @var string
     */
    public $author_name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var integer
     */
    public $ip_address;

    /**
     *
     * @var string
     */
    public $user_agent;

    /**
     *
     * @var string
     */
    public $comment_contents;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $parent_id;

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
        $this->setSource("here_article_comments");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    final public function getSource() {
        return 'here_article_comments';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticleComments[]|HereArticleComments|\Phalcon\Mvc\Model\ResultSetInterface
     */
    final public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HereArticleComments|\Phalcon\Mvc\Model\ResultInterface
     */
    final public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }
}