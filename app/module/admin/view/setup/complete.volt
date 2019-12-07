<header class="h-setup-header">
  <div class="h-setup-header-container h-container h-middle-center">
    <p class="h-setup-header-title">{{ _t('setup_error_occurs') }}</p>
    <p class="h-setup-header-tips">{{ _t('setup_error_tips') }}</p>
  </div>
</header>

<main class="h-setup-main">
  <div class="h-setup-container h-container h-middle-center">
    <div class="h-setup-error-reason">
      <h4>{{ _t('setup_error_reason_title') }}</h4>
      <div class="h-setup-error-stacktrace">
        <pre>{{ error_message }}</pre>
        <pre>{{ error_stacktrace }}</pre>
      </div>
    </div>

    <div class="h-setup-retry">
      <a href="{{ url('/admin/setup') }}"><button>{{ _t('button_retry') }}</button></a>
    </div>
  </div>
</main>
