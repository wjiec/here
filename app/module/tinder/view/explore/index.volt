<header class="h-explore-header">
  <div class="h-explore-author h-container">
    <h2 class="h-explore-author-nickname" style="color: {{ color.random() }}">
      {{ administrator.model().author_nickname | capitalize }}
    </h2>
    {% if administrator.model().author_introduction %}
      <p class="h-explore-author-introduction">{{ administrator.model().author_introduction }}</p>
    {% endif %}
  </div>
</header>

<main class="h-explore-body">
  <section class="h-explore-articles h-container">
    {% for article in articles %}
    <article class="h-explore-article">
      <div class="h-explore-article-header h-container">
        <h4 class="h-explore-article-title">
          <a href="{{ url('/article/' ~ article.article_abbr) }}">{{ article.article_title }}</a>
        </h4>
        <div class="h-explore-article-metadata">
          <p class="h-explore-article-create-time">
            {{ article.create_time | date }}
          </p>
        </div>
      </div>
      <div class="h-explore-article-outline">
        {{ article.article_outline | markdown }}
      </div>
    </article>
    {% endfor %}
  </section>
</main>

<footer class="h-explore-footer">

</footer>
