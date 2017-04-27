<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- HookPointer: index-title($this->_title) -->
    <title>{{ title | +index-title }}</title>
</head>
<body>
    <header id="here-index-header" class="flex-container-center">
        <div id="progress" class="widget-progress"></div>
        <!-- HookPointer: index-header() -->
        {{ +index-header }}
    </header>
    <section id="here-index-container" class="flex-container-column">
    {{ @for (@get_articles : key => val) }}
        <article class="here-index-article">
            <header class="here-article-header">
                <h1 class="here-article-title"></h1>
            </header>
            <section class="here-article-container">
                <p></p>
                <p></p>
                <p></p>
            </section>
            <footer class="here-article-footer">
                <div class="here-article-comment"></div>
                <div class="here-article-view"></div>
            </footer>
        </article>
    {{ @endfor }}
    </section>
    <footer id="here-index-footer">
        <div id="here-footer-copyright">
            <p>{{ Core@copyright }}</p>
        {{ @if (icp_filing) }}
            <p>{{ icp_filing }}</p>
        {{ @endif }}
        </div>
    </footer>
</body>
</html>
