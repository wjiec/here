{% include 'includes/header.volt' %}

<main class="h-body">
  <div class="h-container">
    {% for article in articles %}
    <article class="h-article">
      <section class="h-article-header">
        <div class="h-article-title">
          <h3>{{ article.article_title }}</h3>
        </div>
        <div class="h-article-metadata">
          <p>{{ article.create_time }} - {{ article.author.author_nickname }}</p>
        </div>
      </section>
    </article>
    {% endfor %}
  </div>
</main>

