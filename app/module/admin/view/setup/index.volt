<header class="h-header h-setup-header">
  <div class="h-setup-header-container h-container h-middle-center h-is-vertical">
    <p class="h-setup-header-title">{{ _t('setup_wizard_title') }}</p>
    <p class="h-setup-header-tips">{{ _t('setup_wizard_tips') }}</p>
  </div>
</header>

<main class="h-container h-setup-container">
  <form action="{{ url('/admin/setup/complete') }}" method="post" class="h-form">
    <div class="h-form-item">
      <label class="h-form-label" for="administrator-username">{{ _t("setup_wizard_form_username") }}</label>
      <div class="h-form-input"><input type="text" id="administrator-username"></div>
    </div>
    <div class="h-form-item">
      <label class="h-form-label" for="administrator-password">{{ _t("setup_wizard_form_password") }}</label>
      <div class="h-form-input"><input type="text" id="administrator-password"></div>
    </div>
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
  </form>
</main>
