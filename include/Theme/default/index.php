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
          # from database getting articles
          return array(
              array( # article, database
                  'url'  => 'http://localhost/article/template-test-case', # user-customer or auto generate(baidu or google?)
                  'title' => 'Template Test Case',
                  'time' => '1469614077', # timestrap
                  'contents' => '<p>Template Test Case</p><p>This is an article contents.</p>', # markdown
                  'count(`id`)' => '21' # left join `table.comments` 
              )
          );
      }, array( # keys mapping
          'url' => 'article_url',
          'time' => 'post_time',
          'contents' => 'article_contents',
          'count(`id`)' => 'comments_count'
      )) ?>
        <article class="index-article">
            <header><h1 class="index-article-title"><a href="">Hello Here Blog</a></h1></header>
            <div class="index-article-contents">
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
            </div>
            <div class="index-article-footer flex-container">
                <div class="article-footer-post-time">Mar 15, 2016</div>
                <div class="article-footer-comments"><a href="#comments">15 Comments</a></div>
            </div>
        </article>
        <article class="index-article">
            <header><h1 class="index-article-title"><a href="">Hello Here Blog</a></h1></header>
            <div class="index-article-contents">
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
            </div>
            <div class="index-article-footer flex-container">
                <div class="article-footer-post-time">Mar 15, 2016</div>
                <div class="article-footer-comments"><a href="#comments">15 Comments</a></div>
            </div>
        </article>
        <article class="index-article">
            <header><h1 class="index-article-title"><a href="">Hello Here Blog</a></h1></header>
            <div class="index-article-contents">
                <p>Welcome to this family. This family is fun, firendly.</p>
                <p>Homepage: <a href="http://here.shellboot.com" target="_blank">ShellBoot</a></p>
                <p>Github: <a href="https://github.com/JShadowMan/here" target="_blank">Github</a></p>
                <p>We are family.</p>
            </div>
            <div class="index-article-footer flex-container">
                <div class="article-footer-post-time">Mar 15, 2016</div>
                <div class="article-footer-comments"><a href="#comments">15 Comments</a></div>
            </div>
        </article>
    </div>
    
    <div id="index-paging" class="flex-container">
        <div><div id="index-paging-left" class="paging-disable"></div></div>
        <div><div id="index-paging-right"></div></div>
    </div>
</section>
<?php Widget_Theme_Helper::footerRenderer()->render() ?>
