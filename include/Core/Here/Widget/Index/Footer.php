<?php
/**
 * @author ShadowMan
 */
class Widget_Index_Footer implements Widget_Abstract {
    /**
     * @see Widget_Abstract::start()
     */
    public static function start() {
?>
    <footer class="container-fiuld">
        <div id="here-copyright" class="row">
            <p class="col-xl-6 col-xl-offset-3 col-lg-7 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">Proudly Powered By <a href="https://github.com/jshadowman/here" target="_blank">Here</a></p>
            <?php Plugins_Manage::hook('index@footer'); ?>
        </div>
    </footer>
<?php
    }
}

?>