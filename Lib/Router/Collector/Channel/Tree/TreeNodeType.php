<?php
/**
 * TreeNodeType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel\Tree;
use Here\Lib\Extension\Enum\EnumType;


/**
 * Class TreeNodeType
 * @package Here\Lib\Router\Collector\Channel\Tree
 */
final class TreeNodeType extends EnumType {
    /**
     * node type: root-path
     */
    public const NODE_TYPE_MATCHED_CHANNEL = 'CB';

    /**
     * node type: scalar-path
     */
    public const NODE_TYPE_SCALAR_PATH = 'SCALAR';

    /**
     * node type: variable-complex-path
       */
    public const NODE_TYPE_VAR_COMPLEX_PATH = 'VAR_COMPLEX';

    /**
     * node type: optional-complex-path
     */
    public const NODE_TYPE_OPT_COMPLEX_PATH = 'OPT_COMPLEX';

    /**
     * node type: composite-path
     */
    public const NODE_TYPE_COMPOSITE_PATH = 'COMPOSITE';

    /**
     * node type: full-match-path
     */
    public const NODE_TYPE_FULL_MATCH_PATH = "FULL_MATCH";
}
