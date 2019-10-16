<section>
    {% for article in articles %}
    <article>
        <h1>{{ article.article_title }}</h1>
        <div>
            <span>{{ article.article_outline }}</span>
        </div>
        <div>
            <pre>{{ article.article_body }}</pre>
        </div>
        <div>
            <span>{{article.create_time}}</span> <span>{{article.update_time}}</span>
        </div>
    </article>
    {% endfor %}
</section>
