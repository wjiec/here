<header class="h-admin-header">
  <div class="h-admin-header-container h-container h-is-horizontal">
    {% set author_avatar = administrator.model().author_avatar %}
    <div class="h-admin-header-left">
      <div class="h-admin-header-avatar" style="background-image: url({{ author_avatar | avatar }})">
        <a href="{{ url(['for': 'explore']) }}"></a>
      </div>
    </div>
    <div class="h-admin-header-right">
      <div class="h-admin-welcome">
        <p>{{ welcome.say() }}{{ administrator.model().author_nickname | capitalize }}</p>
      </div>
      <div class="h-admin-logout">
        <form action="{{ url(['for': 'logout']) }}" method="post" class="h-form-inline">
          <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
          <button data-text>{{ _t('button_logout') }}</button>
        </form>
      </div>
    </div>
  </div>
</header>
