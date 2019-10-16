<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Providers\Field;


/**
 * Class Store
 * @package Here\Providers\Field
 */
final class Store {

    /**
     * @var string
     */
    private $field;

    /**
     * Store constructor.
     * @param string $field
     */
    final public function __construct(string $field) {
        $this->field = $field;
    }

}
