
<main class="h-login-container h-container h-content-box {{ exp(error_message, 'h-login-has-error', '') }}">
  <h4 class="h-login-title">{{ _t('title_admin_login_index') }}</h4>
  <section class="h-login-card">
    <div class="h-login-form">
      <form action="{{ url(['for': 'login']) }}" method="post">
        {# Form username #}
        <div class="h-form-item">
          <label class="h-form-label" for="username">{{ _t('form_label_username') }}</label>
          <div class="h-form-control">
            <input name="username" id="username" placeholder="{{ _t('form_placeholder_username') }}">
          </div>
        </div>
        {# Form password #}
        <div class="h-form-item">
          <label class="h-form-label" for="password">{{ _t('form_label_password') }}</label>
          <div class="h-form-control">
            <input type="password" name="password" id="password" placeholder="{{ _t('form_placeholder_password') }}">
          </div>
        </div>
        {# Form submit buttons #}
        <div class="h-form-item">
          <div class="h-form-control">
            <button>{{ _t("form_submit_text") }}</button>
            <span class="h-back-prev-page">
              <a href="{{ url(['for': 'explore']) }}">{{ _t('button_back_home') }}</a>
            </span>
          </div>
        </div>
        {# Csrf token #}
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
      </form>
    </div>
    {% if error_message is defined %}
      <div class="h-login-error-message">
        <p>{{ error_message }}</p>
      </div>
    {% endif %}
  </section>
</main>
