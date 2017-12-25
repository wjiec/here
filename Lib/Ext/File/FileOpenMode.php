<?php
/**
 * FileOpenMode.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\File;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class FileOpenMode
 * @package File
 */
final class FileOpenMode extends EnumType {
    /**
     * default mode
     */
    public const __default = self::FILE_OPEN_MODE_READ_ONLY;

    /**
     * open mode: read only
     */
    public const FILE_OPEN_MODE_READ_ONLY = 0x0001;

    /**
     * open mode: writable
     */
    public const FILE_OPEN_MODE_WRITABLE = 0x0002;

    /**
     * open mode: append
     */
    public const FILE_OPEN_MODE_APPEND = 0x0004;

    /**
     * open mode: read only binary
     */
    public const FILE_OPEN_MODE_BINARY_READ_ONLY = 0x0010;

    /**
     * open mode: writable binary
     */
    public const FILE_OPEN_MODE_BINARY_WRITABLE = 0x0020;

    /**
     * open mode: append binary
     */
    public const FILE_OPEN_MODE_BINARY_APPEND = 0x0040;
}
