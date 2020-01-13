{%- macro menu_item(item) %}
<div class="h-admin-menu-item">
  <a href="{{ item.url }}"><p>{{ item.name }}</p></a>
</div>
{%- endmacro %}


<div class="h-admin-menu">
  {% for item in this.menu %}
    {% if item.children is defined %}
      <div class="h-admin-menu-item h-menu-has-folder">
        <div class="h-menu-folder">
          <p class="h-menu-folder-handler">{{ item.name }}</p>
          <i class="h-menu-folder-arrow"></i>
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
