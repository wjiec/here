{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-search-container">
    <section class="h-search-form-container h-container h-content-box">
      <form action="{{ url('/search') }}" method="post" class="h-form-inline">
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="search">{{ _t('form_label_search') }}</label>
          <div class="h-form-control" data-submit>
            <input name="search" id="search" placeholder="{{ _t('form_placeholder_search') }}" autofocus />
          </div>
        </div>
        {# Csrf token #}
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
      </form>
    </section>
  </main>

  {% include 'includes/footer.volt' %}
</div>

{% include 'includes/widgets/back-to-top.volt' %}

<script>
  new here.Sidebar(here._$('.h-common-wrapper')).init();
  new here.BackToTop(300, 500).init();
</script>
