<?php
    $this->renderer('header.php')->title(Manager_Widget::widget('helper')->options()->title)
         ->stylesheet('library/grid-alpha')
         ->stylesheet('modules/index')
         ->javascript('index')
         ->render()
    ;
?>
<section id="left-screen">
    <h1 class="widget-hidden">Left Screen</h1>
    
</section>
<section id="main-screen" class="container">
    <h1 class="widget-hidden">Main Screen</h1>
    
</section>
<?php $this->renderer('footer.php'); ?>
