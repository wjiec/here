{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-container h-content-box">
    {% include 'includes/error/error.volt' %}
  </main>

  {% include 'includes/footer.volt' %}
</div>

{% include 'includes/widgets/back-to-top.volt' %}

<script>
    new here.Sidebar(here._$('.h-common-wrapper')).init();
    new here.BackToTop(300, 500).init();
</script>
