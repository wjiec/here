#- Main Loop, Shorthand, => { foreach @data - @__index + @__value }
{ loop }
<article class="index-article">
    <header><h1 class="index-article-title"><a href="{ @article_url }">{ @title }</a></h1></header>
    <div class="index-article-contents">
        { @article_contents }
    </div>
    <div class="index-article-footer flex-container">
        <div class="article-footer-post-time">{ @post_time $ (time.format("M d, Y")) }</div>
        <div class="article-footer-comments"><a href="{ @article_url }#comments">{ @comments_count } Comment{ if @comments_count > 1: }s{ endif }</a></div>
    </div>
</article>
{ endloop }
