<?php
    $this->headerRenderer('header.php')->title(Manager_Widget::widget('helper')->options()->title)
         ->stylesheets('library/grid-alpha', 'modules/index', '123')
         ->javascripts('index')
         ->render()
    ;
?>
<section id="left-screen">
    <h1 class="widget-hidden">Left Screen</h1>
    
</section>
<section id="main-screen" class="container">
    <h1 class="widget-hidden">Main Screen</h1>
    
</section>
<?php $this->footerRenderer()
           ->render()
?>
