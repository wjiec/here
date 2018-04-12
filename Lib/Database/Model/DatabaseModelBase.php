<?php
/**
 * DatabaseModelBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model;
use Here\Lib\Database\Model\Meta\DatabaseModelMetaData;
use Here\Lib\Database\Model\Meta\Parser\DatabaseModelMetaParser;
use Here\Lib\Database\Adapter\DatabaseAdapterInterface;
use Here\Lib\Database\Criteria\DatabaseCriteriaInterface;
use Here\Lib\Database\DatabaseHelper;
use Here\Lib\Database\Model\Collection\DatabaseModelCollectionInterface;


/**
 * Class DatabaseModelBase
 * @package Here\Lib\Database\Model
 */
abstract class DatabaseModelBase implements DatabaseModelInterface {
    /**
     * @var int
     * @field int, not null
     */
    public $create_at;

    /**
     * @var int
     * @field int, not null
     */
    public $update_at;

    /**
     * @var DatabaseModelMetaData
     */
    private static $_model_meta;

    /**
     * DatabaseModelBase constructor.
     */
    final public function __construct() {
        self::pre_init_model();
    }

    /**
     * @return DatabaseAdapterInterface
     */
    final protected static function connection(): DatabaseAdapterInterface {
        return DatabaseHelper::get_adapter();
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelInterface
     */
    final public static function one(DatabaseCriteriaInterface $criteria): DatabaseModelInterface {
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    final public static function all(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface {
    }

    /**
     * @param DatabaseCriteriaInterface $criteria
     * @return DatabaseModelCollectionInterface
     */
    final public static function find(DatabaseCriteriaInterface $criteria): DatabaseModelCollectionInterface {
    }

    /**
     * @return bool
     */
    final public function persistent(): bool {
        return true;
    }

    /**
     * 1. check current model initialized
     * 2. reflection current model when first
     */
    final protected static function pre_init_model(): void {
        if (!self::$_model_meta) {
            self::reflection_model();
        }
    }

    /**
     * reflection current model and create meta data
     */
    final private static function reflection_model(): void {
        self::$_model_meta = new DatabaseModelMetaData();

        $ref = new \ReflectionClass(get_called_class());
        foreach ($ref->getProperties() as $property) {
            self::$_model_meta->add_field($property->getName(),
                DatabaseModelMetaParser::parse($property->getDocComment()));
        }

        var_dump(self::$_model_meta);
    }
}
