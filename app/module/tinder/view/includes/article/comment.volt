{% if article is defined %}
  <section class="h-article-comment-container">
    {% for comment in article.getApprovalComments() %}
    <section class="h-article-comment" id="comment-{{ comment.comment_id }}">
      <div class="h-article-comment-header">
        <h4 class="h-article-commentator">{{ comment.commentator_nickname }}</h4>
      </div>
      <div class="h-article-comment-body">
        {{ comment.comment_body | security_markdown }}
      </div>
      <div class="h-article-comment-footer">
        <p class="h-article-comment-time">{{ comment.create_time | date }}</p>
        <i class="h-separator"></i>
        <p class="h-article-comment-anchor"><a href="#comment-{{ comment.comment_id }}">#</a></p>
        <i class="h-separator"></i>
        <p class="h-article-comment-reply"><a>{{ _t('button_reply') }}</a></p>
      </div>
    </section>
    {% endfor %}
  </section>

  {% if article.isArticleAllowComment() %}
    <section class="h-article-comment-create">
      <form action="{{ url('/article/comment') }}" method="post">
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="nickname">{{ _t('form_label_nickname') }}</label>
          <div class="h-form-control">
            <input name="nickname" id="nickname" placeholder="{{ _t('form_placeholder_nickname') }}" />
          </div>
        </div>
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="email">{{ _t('form_label_email') }}</label>
          <div class="h-form-control">
            <input name="email" type="email" id="email" placeholder="{{ _t('form_placeholder_email') }}" />
          </div>
        </div>
        <div class="h-form-item" data-required>
          <label class="h-form-label" for="comment">{{ _t('form_label_comment') }}</label>
          <div class="h-form-control">
            <textarea name="comment" id="comment" placeholder="{{ _t('form_placeholder_comment') }}"></textarea>
          </div>
          <div class="h-form-tips">
            <p>{{ _t('form_tips_comment') }}</p>
          </div>
        </div>
        <div class="h-form-item">
          <div class="h-form-control">
            <button>{{ _t("form_submit_text") }}</button>
          </div>
        </div>
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
        <input type="hidden" name="article_id" value="{{ article.article_id }}">
      </form>
    </section>
  {% endif %}
{% endif %}
