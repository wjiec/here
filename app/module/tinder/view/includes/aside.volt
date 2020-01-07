<aside class="h-common-aside">
  <div class="h-common-sidebar h-container">
    <section class="h-common-sidebar-author">
      <p>{{ administrator.model().author_nickname | capitalize }}</p>
    </section>
    <section class="h-common-sidebar-links">
      <p><a href="{{ url(['for': 'explore']) }}">{{ _t('sidebar_link_blog') }}</a></p>
      {% for link in field.get('sidebar.links', []) %}
        <p><a href="{{ link['url'] }}" target="{{ link['target'] }}">{{ link['name'] }}</a></p>
      {% endfor %}
      {% if field.get('sidebar.link.github', '') %}
        <p><a href="{{ field.get('sidebar.link.github') }}" target="_blank">{{ _t('sidebar_link_github') }}</a></p>
      {% endif %}
      <p><a href="{{ url('/search') }}">{{ _t('sidebar_link_search') }}</a></p>
      <p><a href="{{ url('/feed') }}">{{ _t('sidebar_link_feed') }}</a></p>
      {% if administrator.loginFromToken() %}
        <p><a href="{{ url(['for': 'dashboard']) }}">{{ _t('title_admin_dashboard_index') }}</a></p>
      {% endif %}
    </section>
    <section class="h-common-sidebar-license">
      <p>
        {{ _t('sidebar_license_cc_notice') }}
        <a href="{{ field.get('content.license.url', config.license.url) }}" target="_blank">
          {{ field.get('content.license.name', config.license.name) }}
        </a>
      </p>
    </section>
  </div>
</aside>
