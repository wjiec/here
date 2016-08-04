<?php
    // @var $this Widget_Theme_Helper
    Widget_Theme_Helper::headerRenderer('header.php')->title(Manager_Widget::widget('helper')->options()->title)
         ->keywords('Blog', 'Person Blog', 'JShadowMan') // fetch from database
         ->description('JShadowMan\'Blog, Test Case')
         ->meta('og:type', 'blog') // test case
         ->stylesheets('library/grid-alpha-flex', 'modules/index')
         ->stylesheets('library/fonts/fira', 'library/fonts/inconsolata')
         ->javascripts('index')
         ->render();
?>
<!-- Header { loader-bar } -->
<header>
    <div id="jax-loader-bar" class="is-loading"></div>
    <?php Manager_Plugin::hook('index@header') ?>
</header>
<!-- Left Contents { Title, Category, Article List, Admin, More } -->
<section id="left-screen" class="flex-container">
    <h1 class="widget-hidden">Left Screen</h1>
    <div id="left-contents">
        <!-- Title -->
        <section id="index-left-title" class="flex-container-column flex-items-align-vh">
            <h1><?php $this->options()->title('Anonymous Blog. WOW') ?></h1>
            <h2><?php $this->options()->subTitle('Hello World, Hello Here Blog') // TODO. SubTitle ?></h2>
        </section>
        <?php Manager_Plugin::hook('index@left-title-after') ?>
        <!-- Category -->
        <section id="index-left-category">
            <h1>Category</h1>
            <ul id="left-category-list">
                <li class="left-category-item"><a href="">Default (100)</a></li>
                <li class="left-category-item"><a href="">Life (10)</a>
                    <ul id="left-category-list">
                        <li class="left-category-item"><a href="">Project (56)</a></li>
                        <li class="left-category-item"><a href="">Photo (12)</a></li>
                    </ul>
                </li>
                <li class="left-category-item"><a href="">Project (12)</a></li>
                <li class="left-category-item"><a href="">Photo (2)</a></li>
                <li class="left-category-item"><a href="">Where are you from (56)</a></li>
                <li class="left-category-item"><a href="" title="Very long long long category name">Very long long long category name (1)</a></li>
            </ul>
        </section>
        <?php Manager_Plugin::hook('index@left-category-after') ?>
        <!-- Article List -->
        <section id="index-left-article-list">
            <h1>Article List</h1>
            <ul id="left-article-list" class="flex-container-column">
                <li class="left-article-item"><a href="">Hello World</a></li>
                <li class="left-article-item flex-item-top lock-top"><a href="">Hello Here Blog</a></li>
                <li class="left-article-item"><a href="">Very Long Long Long Article Title</a></li>
                <li class="left-article-item"><a href="">This is a article title</a></li>
                <li class="left-article-item"><a href="">Nice to meet you</a></li>
            </ul>
        </section>
        <?php Manager_Plugin::hook('index@left-article-after') ?>
        <!-- Admin -->
        <section id="index-left-admin-list">
            <h1>Admin</h1>
            <ul id="left-admin-list">
                <li class="left-admin-item"><a href="<?php echo Request::getFullUrl('/dashboard/') ?>">LOGIN</a></li>
              <?php if (Manager_Widget::widget('user')->logined()): ?>
                <li class="left-admin-item"><a href="">CUSTOM</a></li>
              <?php endif ?>
            </ul>
        </section>
        <?php Manager_Plugin::hook('index@left-admin-after') ?>
        <!-- More -->
        <section id="index-left-more">
            <h1>More</h1>
            <ul id="left-more-items">
                <li class="left-more-item"><a href="">About Me</a></li>
            </ul>
        </section>
        <?php Manager_Plugin::hook('index@left-end') ?>
    </div>
    <div id="touch-toggle" class="flex-container flex-items-align-vh"></div>
</section>
<!-- Main Contents { Article [ Hot, New ] } -->
<section id="main-screen" class="container">
    <h1 class="widget-hidden">Main Screen</h1>
    <div id="index-main-article-list" class="flex-container-column">
        <?php Manager_Widget::widget('parser')->article(function() {
            $articleDb = new Db();

            # from database getting articles
            $articleDb->query($articleDb->select()->from('table.articles')->limit(Manager_Widget::widget('options')->pageSize));
            return $articleDb->fetchAll();
        }, array( # keys mapping
            'url' => 'article_url',
            'created' => 'post_time',
            'contents' => 'article_contents',
            'comments_cnt' => 'comments_count'
        )) ?>
    </div>

    <?php if (Manager_Widget::widget('helper')->allPageCount() > 1): ?>
    <div id="index-paging" class="flex-container">
        <div><div id="index-paging-left" class="paging-disable"></div></div>
        <div><div id="index-paging-right"></div></div>
    </div>
    <?php endif ?>
</section>
<?php Widget_Theme_Helper::footerRenderer()->render() ?>
