<div class="h-error h-error-404">
  <div class="h-container h-content-box">
    <h4 class="h-error-title">
      {% if error_title is defined %}
        {{ error_title }}
      {% else %}
        {{ _t('error_not_found_title') }}
      {% endif %}
    </h4>
    <div class="h-error-body"></div>
    <script>_$('.h-sidebar-control').style.animation = 'shrink 3s ease-out infinite';</script>
  </div>
</div>
