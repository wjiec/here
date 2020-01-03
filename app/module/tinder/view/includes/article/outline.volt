<article class="h-outline">
  <div class="h-outline-header h-container">
    <h4 class="h-outline-title">
      <a href="{{ url('/article/' ~ article.article_abbr) }}">{{ article.article_title }}</a>
    </h4>
    <div class="h-outline-metadata">
      <p class="h-outline-create-time">
        {{ article.create_time | date }}
      </p>
    </div>
  </div>
  <div class="h-outline-content">
    {{ article.article_outline | markdown }}
  </div>
</article>
