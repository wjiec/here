{% if state is defined and state.getTotal() != 1 %}
  <div class="h-widget-pager">
    <div class="h-container h-is-horizontal h-content-box">
      <div class="h-pager-item h-pager-prev {{ !state.hasPrev() ? 'h-pager-disabled' : '' }}">
        {% if state.hasPrev() %}
          <a href="{{ state.getPrevUrl() }}"></a>
        {% else %}
          <a></a>
        {% endif %}
      </div>

      {% if state.hasPrevTurn() %}
        <div class="h-pager-item"><a href="{{ state.getUrl(1) }}">{{ 1 }}</a></div>
        {% if state.getPagerIteratorStart() != 2 %}
          <div class="h-pager-item h-pager-turn"><a href="{{ state.getPrevTurnUrl() }}"></a></div>
        {% endif %}
      {% endif %}

      {% for index in state.getPagerIterator() %}
        <div class="h-pager-item {{ index == state.getCurrent() ? 'h-pager-activated' : '' }}">
          {% if index != state.getCurrent() %}
            <a href="{{ state.getUrl(index) }}">{{ index }}</a>
          {% else %}
            <a>{{ index }}</a>
          {% endif %}
        </div>
      {% endfor %}

      {% if state.hasNextTurn() %}
        {% if state.getPagerIteratorEnd() != state.getTotal() - 1 %}
          <div class="h-pager-item h-pager-turn"><a href="{{ state.getNextTurnUrl() }}"></a></div>
        {% endif %}
        <div class="h-pager-item"><a href="{{ state.getUrl(state.getTotal()) }}">{{ state.getTotal() }}</a></div>
      {% endif %}

      <div class="h-pager-item h-pager-next {{ !state.hasNext() ? 'h-pager-disabled' : '' }}">
        {% if state.hasNext() %}
          <a href="{{ state.getNextUrl() }}"></a>
        {% else %}
          <a></a>
        {% endif %}
      </div>
    </div>
  </div>
{% endif %}
