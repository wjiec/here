{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-explore-body">
    {% if category is defined and category !== null %}
      <section class="h-category-container h-container h-content-box">
        <div class="h-category-header">
          <h4>{{ category.category_name }}</h4>
          <div class="h-category-intro">
            <p>{{ category.category_introduction | default('...') }}</p>
          </div>
        </div>
      </section>
      <section class="h-articles">
        {% for article in articles %}
          <article class="h-article">
            <div class="h-article-header h-container">
              <h4 class="h-article-title">
                <a href="{{ url('/article/' ~ article.article_abbr) }}">{{ article.article_title }}</a>
              </h4>
              <div class="h-article-metadata">
                <p class="h-article-create-time">
                  {{ article.create_time | date }}
                </p>
              </div>
            </div>
            <div class="h-article-outline">
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
