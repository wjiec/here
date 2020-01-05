{% include 'includes/aside.volt' %}

<div class="h-common-wrapper">
  {% include 'includes/header.volt' %}

  <main class="h-article-comment-error h-container h-content-box">
    {% include 'includes/error/error' with ['error_title': error_message] %}

    <div class="h-article-comment-buttons h-container h-is-horizontal">
      <p><a href="javascript:window.history.back();">{{ _t('button_back_page') }}</a></p>
      <p><a href="{{ url(['for': 'explore']) }}">{{ _t('button_back_home') }}</a></p>
    </div>
  </main>

  {% include 'includes/footer.volt' %}
</div>

{% include 'includes/widgets/back-to-top.volt' %}

<script>
    new Sidebar(_$('.h-common-wrapper')).init();
    new BackToTop(300, 500).init();
</script>
