<div class="h-admin-menu">
  {% for item in this.menu %}
    {% if item.children is defined %}
      <div class="h-admin-menu-item h-menu-sub">
        <p>{{ item.name }}</p>
      </div>
    {% else %}
      <div class="h-admin-menu-item">
        <a href="{{ item.url }}"><p>{{ item.name }}</p></a>
      </div>
    {% endif %}
  {% endfor %}
</div>
