{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

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

  {% include 'includes/footer.volt' %}
</div>

<script>new Sidebar(_$('.h-common-wrapper')).init();</script>
