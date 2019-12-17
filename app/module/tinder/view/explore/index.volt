<header class="h-explore-header">
  <div class="h-container"></div>
</header>

<main class="h-explore-body">
  <section class="h-explore-articles h-container">
    {% for article in articles %}
    <article class="h-explore-article">
      <!-- Article header -->
      <div class="h-explore-article-header">
        <h4 class="h-explore-article-title">
          <a href="{{ url('/article/' ~ article.article_abbr) }}">{{ article.article_title }}</a>
        </h4>
        <!-- Article outline/content -->
        <div class="h-explore-article-metadata">
          <p class="h-explore-article-create-time">
            {{ article.create_time | date }}
          </p>
        </div>
      </div>
      <!-- Article Body -->
      <div class="h-explore-article-outline">
        {{ article.article_outline | markdown }}
      </div>
      <!-- Article Footer -->
      <div class="h-explore-article-footer">
        <div class="h-container h-is-horizontal">
          <p class="h-explore-article-like">
            <i class="h-icon-like"></i><span>{{ article.article_like }}</span>
          </p>
          <p class="h-explore-article-comment">
            <i class="h-icon-comment"></i><span>0</span>
          </p>
          <p class="h-explore-article-category">
            <i class="h-icon-category"></i><span>0</span>
          </p>
        </div>
      </div>
    </article>
    {% endfor %}
  </section>
</main>

<footer class="h-explore-footer">

</footer>
