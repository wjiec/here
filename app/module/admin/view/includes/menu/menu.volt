{%- macro menu_item(item) %}
<div class="h-admin-menu-item" data-activated="{{ exp(item.activated, 'yes', 'no') }}">
  <div class="h-menu-handler">
    <a href="{{ item.url }}"><p>{{ item.title }}</p></a>
  </div>
</div>
{%- endmacro %}


<div class="h-admin-menu">
  {% for item in menu.getConfig() %}
    {% if item.children is defined %}
      <div class="h-admin-menu-item h-menu-has-folder" data-open="{{ exp(item.opened, 'yes', 'no') }}">
        <div class="h-menu-handler">
          <p>{{ item.title }}</p>
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
