<header class="h-setup-header">
  <div class="h-setup-header-container h-container h-middle-center">
    <p class="h-setup-header-title">{{ _t('setup_wizard_title') }}</p>
    <p class="h-setup-header-tips">{{ _t('setup_wizard_tips') }}</p>
  </div>
</header>

<main class="h-setup-main">
  <div class="h-setup-container h-container">
    <section class="h-setup-description">
      <p>{{ _t('setup_wizard_welcome') }}</p>
      <p>{{ _t('setup_wizard_slogan') }}</p>
      <p>{{ _t('setup_wizard_steps') }}</p>
      <p>{{ _t('setup_wizard_issue') }}</p>
      <p>{{ _t('setup_wizard_robots') }}</p>
    </section>

    <section class="h-setup-form">
      <form action="{{ url('/admin/setup/complete') }}" method="post">
        {# Administrator username #}
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="username">{{ _t('form_label_username') }}</label>
          <div class="h-form-control">
            <input name="username" id="username" placeholder="{{ _t('form_placeholder_username') }}" autofocus />
          </div>
        </div>
        {# Administrator password #}
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="password">{{ _t('form_label_password') }}</label>
          <div class="h-form-control">
            <input type="password" name="password" id="password" placeholder="{{ _t('form_placeholder_password') }}"/>
          </div>
        </div>
        {# Administrator email #}
        <div class="h-form-item">
          <label class="h-form-label" for="email">{{ _t('form_label_email') }}</label>
          <div class="h-form-control">
            <input type="email" name="email" id="email" placeholder="{{ _t('form_placeholder_email') }}"/>
          </div>
        </div>
        {# Form submit buttons #}
        <div class="h-form-item">
          <div class="h-form-control">
            <button>{{ _t("form_submit_text") }}</button>
          </div>
        </div>
        {# Csrf token #}
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
      </form>
    </section>
  </div>
</main>

<script>
  here._$on('form', 'submit', (e) => {
    if (!new here.Validator(e.target).validate()) {
      e.preventDefault();
    }
  });
</script>
