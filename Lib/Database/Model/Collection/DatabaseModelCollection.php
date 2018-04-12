<?php
/**
 * DatabaseModelCollection.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model\Collection;
use Here\Lib\Database\Model\DatabaseModelInterface;


/**
 * Class DatabaseModelCollection
 * @package Here\Lib\Database\Model\Collection
 */
final class DatabaseModelCollection implements DatabaseModelCollectionInterface {
    /**
     * @var DatabaseModelInterface[]
     */
    private $_models;

    /**
     * DatabaseModelCollection constructor.
     * @param array $models
     */
    final public function __construct(array $models) {
        $this->_models = array_filter($models,
            function($model): bool {
                return $model instanceof DatabaseModelInterface;
            }
        );
    }

    /**
     * @return \Iterator
     */
    final public function getIterator(): \Iterator {
        return new \ArrayIterator($this->_models);
    }
}
