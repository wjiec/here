{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-explore-body">
    {% if articles.count() !== 0 %}
      <section class="h-explore-articles h-container h-content-box">
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
