{% if render is defined %}
  <div class="h-widget-pager">
    <div class="h-container h-is-horizontal">
      {{ render.render('<p><span><a href="{:url}">{:page}</a></span><p>') }}
    </div>
  </div>
{% endif %}
