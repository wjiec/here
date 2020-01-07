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
        <p><a href="">{{ _t('button_logout') }}</a></p>
      </div>
    </div>
  </div>
</header>
