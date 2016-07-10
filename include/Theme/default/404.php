<?php header('HTTP/1.1 404 Not Found'); ?>
<?php
    // @var $this Widget_Theme_Helper
    Widget_Theme_Helper::headerRenderer('header.php')->title('404 Not Found')
         ->stylesheets('library/grid-alpha', 'library/fonts/inconsolata.css', '404')
         ->render();
?>
<section id="_Here-404">
    <h1>404 Not Found</h1>
</section>
<pre>
    <?php echo self::$errno . ': ' . self::$error; ?>
    <?php var_dump(debug_backtrace()); ?>
</pre>
<?php Widget_Theme_Helper::footerRenderer()->render(); ?>