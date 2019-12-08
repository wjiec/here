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
      <!-- Article footer -->
      <div class="h-explore-article-outline">
        {{ article.article_outline | markdown }}
      </div>
      <div class="h-explore-article-footer">

      </div>
    </article>
    {% endfor %}
  </section>
</main>

<footer class="h-explore-footer">

</footer>
