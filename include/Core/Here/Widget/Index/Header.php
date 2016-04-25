<?php
/**
 * @author ShadowMan
 */
class Widget_Index_Header implements Widget_Abstract {
    /**
     * @see Widget_Abstract::start()
     */
    public static function start() {
?>
    <header>
        <div id="here-jax-loader-bar"><div class="progress"></div></div>
        <?php Plugins_Manage::hook('index@header'); ?>
    </header>
<?php
    }
}

?>