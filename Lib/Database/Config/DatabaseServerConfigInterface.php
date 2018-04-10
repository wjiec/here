<?php
/**
 * DatabaseServerConfigInterface.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Config;


/**
 * Interface DatabaseServerConfigInterface
 * @package Here\Lib\Database\Config
 */
interface DatabaseServerConfigInterface {
    /**
     * @return string
     */
    public function get_name(): string;

    /**
     * @return string
     */
    public function get_dsn(): string;

    /**
     * @return string
     */
    public function get_driver(): string;

    /**
     * @return string
     */
    public function get_host(): string;

    /**
     * @return int
     */
    public function get_port(): int;

    /**
     * @return string
     */
    public function get_username(): string;

    /**
     * @return string
     */
    public function get_password(): string;

    /**
     * @return string
     */
    public function get_database(): string;

    /**
     * @return string
     */
    public function get_charset(): string;

    /**
     * @return array
     */
    public function get_params(): array;
}
