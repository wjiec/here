<header class="h-setup-header">
  <div class="h-setup-header-container h-container h-middle-center h-is-vertical">
    <p class="h-setup-header-title">{{ _t('setup_wizard_title') }}</p>
    <p class="h-setup-header-tips">{{ _t('setup_wizard_tips') }}</p>
  </div>
</header>

<main class="h-setup-main">
  <div class="h-container h-setup-container">
    <form action="{{ url('/admin/setup/complete') }}" method="post" class="h-form">
      <!-- Administrator username -->
      <div class="h-form-item">
        <label class="h-form-label" for="username">{{ _t('form_label_username') }}</label>
        <div class="h-form-input">
          <input type="text" name="username" id="username" placeholder="{{ _t('form_placeholder_username') }}" autofocus />
        </div>
      </div>
      <!-- Administrator password -->
      <div class="h-form-item">
        <label class="h-form-label" for="password">{{ _t('form_label_password') }}</label>
        <div class="h-form-input">
          <input type="password" name="password" id="password" placeholder="{{ _t('form_placeholder_password') }}"/>
        </div>
      </div>
      <!-- Form submit buttons -->
      <div class="h-form-item">
        <button>{{ _t("form_submit_text") }}</button>
      </div>
      <!-- Csrf token -->
      <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
    </form>
  </div>
</main>
