{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-explore-body">
    {% if articles.count() !== 0 %}
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
    {% else %}
      {% include 'includes/error/error.volt' %}
    {% endif %}
  </main>

  {% include 'includes/widgets/pager' with ['state': pager] %}
  {% include 'includes/footer.volt' %}
</div>

{% include 'includes/widgets/back-to-top.volt' %}

<script>
  new Sidebar(_$('.h-common-wrapper')).init();
  new BackToTop(300, 500).init();
</script>
