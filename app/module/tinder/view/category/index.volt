{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-explore-body">
    {% if category is defined and category !== null %}
      <section class="h-category-container h-container">
        <div class="h-category-header">
          <h4>{{ category.category_name }}</h4>
          <div class="h-category-intro">
            <p>{{ category.category_introduction }}</p>
          </div>
        </div>
      </section>
    {% else %}
      {% include 'includes/error/error.volt' %}
    {% endif %}
  </main>

  {% include 'includes/footer.volt' %}
</div>

{% include 'includes/widgets/back-to-top.volt' %}

<script>
    new Sidebar(_$('.h-common-wrapper')).init();
    new BackToTop(300, 500).init();
</script>
