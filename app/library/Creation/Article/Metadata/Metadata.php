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
namespace Here\Library\Creation\Article\Metadata;


use Here\Provider\Field\Store\Adapter\Mixed;

/**
 * Class Metadata
 * @package Here\Library\Creation\Article\Metadata
 * @property string $title
 * @property string $abbr
 * @property string $outline
 * @property bool $access_private
 * @property bool $disallow_comment
 * @property string $body
 */
class Metadata {

    /**
     * Metadata storage, with below components
     *  - title
     *  - abbr
     *  - outline
     *  - access_private
     *  - disallow_comment
     *  - body
     *
     * @var array
     */
    protected $data;

    /**
     * Metadata constructor.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = array_merge([
            'title' => 'untitled article',
            'access_private' => false,
            'disallow_comment' => false
        ], $data);
    }

    /**
     * Sets the body of the metadata
     *
     * @param string $body
     * @return Metadata
     */
    public function setBody(string $body): Metadata {
        $this->data['body'] = $body;
        return $this;
    }

    /**
     * Retrieve the component of metadata
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name) {
        return $this->data[$name] ?? null;
    }

}
