<?php
/**
 * @author ShadowMan
 * @package Here.Interface.Plugin
 */
interface Widget_Plugin {
    /**
     * return this plugin name
     */
    public static function getPluginName();

    /**
     * return this plugin version
     */
    public static function getVersion();

    /**
     * return this plugin author
     */
    public static function getAuthor();

    /**
     * return this plugin homepage
     */
    public static function getHomePage();

    /**
     * run in this plugin start
     */
    public function onEnable();

    /**
     * run in this plugin end
     */
    public function onDisable();
}

?>