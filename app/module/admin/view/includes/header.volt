<header class="h-header">
  <div class="h-container">
    <div class="logo">
      <span><a href="{{ url('/') }}">{{ field.get('blog.name', 'Here') }}</a></span>
    </div>

    <div class="menu">
      <ul>
        {% if this.blogger %}
        <li><a href="">Dashboard</a></li>
        <li><a href="">Articles</a></li>
        <li><a href="">Tags</a></li>
        <li><a href="">Settings</a></li>
        {% else %}
        <li><a href="" data-disabled>Setup Wizard</a></li>
        {% endif %}
      </ul>
    </div>
  </div>
</header>
