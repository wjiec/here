{% include 'includes/header.volt' %}

<main class="h-body">
  <div class="h-container">
    <form action="{{ url('setup-complete') }}" method="post">
      <div class="h-form-item">
        <label for="username">Username</label>
        <div class="h-form-control">
          <input type="text" id="username" name="username" placeholder="username for blogger">
        </div>
      </div>
      <div class="h-form-item">
        <label for="password">Password</label>
        <div class="h-form-control">
          <input type="text" id="password" name="password" placeholder="password for blogger">
        </div>
      </div>
      <div class="h-form-item">
        <button>Register</button>
      </div>
    </form>
  </div>
</main>
