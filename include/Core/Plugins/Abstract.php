<?php
/**
 * Here Plugin Example
 * @author ShadowMan
 * @package Here
 * @abstract Plugins_Abstract
 */

interface Plugins_Abstract {
    /**
     * when running this plugin activated
     * @param void
     * @return void
     * @throws Exception
     */
    public static function activate();
}

?>