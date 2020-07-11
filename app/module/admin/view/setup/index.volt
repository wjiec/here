{% include 'includes/header.volt' %}

<main class="h-body">
  <div class="h-container is-vertical">
    <section class="h-register-describe">
      <p>Hello, this is blog setup wizard.</p>
      <p>Please input username and password below and dont forgot.</p>
      <p>That all, enjoy fun of write and share.</p>
    </section>
    {% if errorMessage is defined %}
    <section class="h-register-error">
      <p>{{ errorMessage }}</p>
    </section>
    {% endif %}
    <section class="h-register-form">
      <form action="{{ url(['for': 'setup-complete']) }}" method="post">
        <div class="h-form-item" data-required>
          <label for="username">Username</label>
          <div class="h-form-control">
            <input type="text" id="username" name="username" placeholder="{{ _t('placeholder_username') }}" autofocus>
          </div>
        </div>
        <div class="h-form-item" data-required data-crypto>
          <label for="password">Password</label>
          <div class="h-form-control">
            <input type="password" id="password" name="password" placeholder="{{ _t('placeholder_password') }}">
          </div>
        </div>
        <div class="h-form-item">
          <div class="h-form-control">
            <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
            <button>Register</button>
          </div>
        </div>
      </form>
    </section>
  </div>
</main>
