<section>
    {% for article in articles %}
    <article>
        <h1>{{ article['title'] }}</h1>
        <div>
            <span>{{ article['description'] }}</span>
        </div>
    </article>
    {% endfor %}
</section>
