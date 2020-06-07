<header class="h-header">
  <div class="h-container">
    <div class="logo">
      <span><a href="{{ url('/') }}">{{ field.get('blog.name', 'Here') }}</a></span>
    </div>
    <div class="menu">
      <ul>
        <li><a href="{{ url('/about') }}">About</a></li>
        <li><a href="{{ url('/about') }}">Tags</a></li>
      </ul>
    </div>
  </div>
</header>
