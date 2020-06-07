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
use Phalcon\Mvc\Model\Resultset\Simple;


/**
 * Class Tag
 *
 * @package Here\Model
 *
 * @property Simple $articles
 * @method Simple getArticles($parameters = null)
 */
class Tag extends Model {

    /**
     *
     * @var integer
     */
    protected $tag_id;

    /**
     *
     * @var string
     */
    protected $tag_name;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     * Method to set the value of field tag_name
     *
     * @param string $tag_name
     * @return $this
     */
    public function setTagName(string $tag_name) {
        $this->tag_name = $tag_name;

        return $this;
    }

    /**
     * Returns the value of field tag_id
     *
     * @return integer
     */
    public function getTagId() {
        return (int)$this->tag_id;
    }

    /**
     * Returns the value of field tag_name
     *
     * @return string
     */
    public function getTagName() {
        return $this->tag_name;
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
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('tag');

        $this->hasMany('tag_id', ArticleTag::class, 'tag_id', [
            'alias' => 'articles',
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'tag';
    }

}
