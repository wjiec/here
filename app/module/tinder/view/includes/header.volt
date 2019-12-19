<header class="h-explore-header">
  <div class="h-explore-author h-container">
    <h2 class="h-explore-author-nickname" style="color: {{ color.random() }}">
      {{ administrator.model().author_nickname | capitalize }}
    </h2>
    {% if administrator.model().author_introduction %}
    <p class="h-explore-author-introduction">{{ administrator.model().author_introduction }}</p>
    {% endif %}
  </div>
</header>
