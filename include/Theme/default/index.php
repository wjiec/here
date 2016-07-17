<?php
    // @var $this Widget_Theme_Helper
    Widget_Theme_Helper::headerRenderer('header.php')->title(Manager_Widget::widget('helper')->options()->title)
         ->stylesheets('library/grid-alpha', 'modules/index')
         ->javascripts('index')
         ->render();
?>
<!-- Header { loader-bar } -->
<header>
    <div id="jax-loader-bar" class="is-loading"></div>
    <?php Manager_Plugin::hook('index@header') ?>
</header>
<!-- Left Contents { Title, Category, Article List, Admin, More } -->
<section id="left-screen">
    <h1 class="widget-hidden">Left Screen</h1>
    <div id="left-contents">
        <!-- Title -->
        <section id="index-left-title">
            <h1><?php $this->options()->title() ?></h1>
            <h2><?php $this->options()->subTitle() // TODO. SubTitle ?></h2>
        </section>
        <!-- Category -->
        <section id="index-left-category">
            <ul id="left-category-list"></ul>
        </section>
        <!-- Article List -->
        <section id="index-left-article-list">
            <ul id="left-article-list"></ul>
        </section>
        <!-- Admin -->
        <section id="index-left-admin">
            
        </section>
        <!-- More -->
        <section id="index-left-more">
            
        </section>
    </div>
    <div id="touch-toggle"></div>
</section>
<!-- Main Contents { Article [ Hot, New ] } -->
<section id="main-screen" class="container">
    <h1 class="widget-hidden">Main Screen</h1>
    <div id="index-main-article-list">
        <article class="index-article"></article>
        <article class="index-article"></article>
        <article class="index-article"></article>
    </div>
</section>

<footer>
    <?php Manager_Plugin::hook('index@footer') ?>
</footer>
<?php Widget_Theme_Helper::footerRenderer()->render() ?>
