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


/**
 * Class Metadata
 * @package Here\Library\Creation\Article\Metadata
 */
class Metadata {

    /**
     * @var array
     */
    protected $data;

    /**
     * Metadata constructor.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

}
