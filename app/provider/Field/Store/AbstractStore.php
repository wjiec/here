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
namespace Here\Provider\Field\Store;


/**
 * Class AbstractStore
 * @package Here\Provider\Field\Store
 */
abstract class AbstractStore implements StoreInterface {

    /**
     * @inheritdoc
     *
     * @param string $key
     * @param $value
     * @return StoreInterface
     */
    public function set(string $key, $value): StoreInterface {
        switch (true) {
            case is_string($value):
                return $this->setString($key, $value);
            case is_integer($value):
                return $this->setInteger($key, $value);
            case is_float($value):
                return $this->setFloat($key, $value);
            case is_bool($value):
                return $this->setBoolean($key, $value);
            default:
                return $this->setSerialized($key, $value);
        }
    }

}
