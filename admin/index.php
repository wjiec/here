<?php
    // @var $this Widget_Theme_Helper
    Widget_Theme_Helper::headerRenderer('header.php')->title('Dashboard')
         ->stylesheets('library/grid-alpha-flex', 'modules/admin')
         ->javascripts('admin')
         ->render();
?>
<header>
    <div id="jax-loader-bar" class="is-loading"></div>
    <?php Manager_Plugin::hook('admin@header') ?>
</header>
<footer>
    <?php Manager_Plugin::hook('admin@footer') ?>
</footer>
<?php Widget_Theme_Helper::footerRenderer()->render() ?>