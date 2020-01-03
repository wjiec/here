{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-category-container">
    {% if category is defined and category !== null %}
      <section class="h-category-header h-container h-content-box">
        <div class="h-category-header-container">
          <h4>{{ category.category_name }}</h4>
          <div class="h-category-intro">
            <p>{{ category.category_introduction }}</p>
          </div>
        </div>
      </section>
      <section class="h-category-articles h-container h-content-box">
        {% for article in articles %}
          {% include 'includes/article/outline' with ['article': article] %}
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
