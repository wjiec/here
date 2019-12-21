<header class="h-common-header">
  <div class="h-common-aside-toggle">
    <i class="h-sidebar-control"></i>
  </div>
  <div class="h-common-header-author h-container">
    <h2 class="h-common-header-author-nickname" style="color: {{ color.random() }}">
      {{ administrator.model().author_nickname | capitalize }}
    </h2>
    {% if administrator.model().author_introduction %}
      <p class="h-explore-author-introduction">{{ administrator.model().author_introduction }}</p>
    {% endif %}
  </div>
</header>

