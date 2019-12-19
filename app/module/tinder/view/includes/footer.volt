{% if field.get('layout.footer.show', true) %}
  <footer class="h-common-footer">
    <div class="h-container h-is-horizontal">
      <div class="h-footer-copyright">
        <p>Isle power by <a href="{{ config.source.github }}" target="_blank">Here</a></p>
      </div>
      <div class="h-footer-best">
        <p>♥ You're the best! ♥</p>
      </div>
    </div>
    {% if field.get('layout.footer.icp', '') %}
    <div class="h-footer-icp h-container h-is-horizontal">
      <a href="http://www.beian.miit.gov.cn" target="_blank">{{ field.get('layout.footer.icp', '') }}</a>
    </div>
    {% endif %}
  </footer>
{% endif %}
