<div class="h-admin-wrapper">
  {% include 'includes/header.volt' %}

  <div class="h-admin-container">
    {% include 'includes/aside.volt' %}

    <main class="h-admin-content h-container">
      {{ content() }}
    </main>
  </div>
</div>

{% block javascript %}
  <script></script>
{% endblock %}
