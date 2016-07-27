{ foreach: @data-@key+@val }
<article class="index-article">

    <test>{ @val.str }</test>
    <test>{ @val.str.abc }</test>
    { foreach: @val.str.abc - @element+@value }
        { @element }
    { endforeach }
    { loop }
        { @abc }
    { endloop }

    <header><h1 class="index-article-title"><a href="{ @article_url }">{ @title }</a></h1></header>
    <div class="index-article-contents">
        { @article_contents }
    </div>
    <div class="index-article-footer flex-container">
        <div class="article-footer-post-time">{ @post_time $ (time.format("d M, Y")) }</div>
        <div class="article-footer-comments"><a href="{ @article_url }#comments">{ @comments_count } Comments</a></div>
    </div>
</article>
{ endforeach }
