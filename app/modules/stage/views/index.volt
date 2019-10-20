<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name=generator content="{{ config.blog.name }}">
    <meta name="description" content="{{ config.blog.description }}">
    <meta name="keyword" content="{{ config.blog.keywords }}">
    <meta name="application-name" content="{{ config.blog.name }}">
    {%- if config.blog.robots -%}
    <link rel="stylesheet" href="./css/style.css">
    <title>{{ get_title(false) ~ ' - ' ~ config.blog.name }}</title>
</head>
<body>
<header>
    header
</header>
<main>
    {{ content() }}
</main>
<footer>
    footer
</footer>
</body>
</html>
