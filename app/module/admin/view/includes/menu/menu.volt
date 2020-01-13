{%- macro menu_item(item) %}
<div class="h-admin-menu-item">
  <div class="h-menu-handler">
    <a href="{{ item.url }}"><p>{{ item.name }}</p></a>
  </div>
</div>
{%- endmacro %}


<div class="h-admin-menu">
  {% for item in this.menu %}
    {% if item.children is defined %}
      <div class="h-admin-menu-item h-menu-has-folder">
        <div class="h-menu-handler">
          <p>{{ item.name }}</p>
          <i class="h-menu-handler-arrow"></i>
        </div>
        <div class="h-admin-sub-menu">
          {% for child in item.children %}
            {{ menu_item(child) }}
          {% endfor %}
        </div>
      </div>
    {% else %}
      {{ menu_item(item) }}
    {% endif %}
  {% endfor %}
</div>
