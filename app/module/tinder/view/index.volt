<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
  <title>{{ get_title(false) ~ ' - ' ~ field.get('blog.name', 'Here') }}</title>
  <link rel="stylesheet" href="{{ static_url('assets/prism/prism.css') }}">
  <link rel="stylesheet" href="{{ static_url('static/style.min.css') }}">
  <link rel="stylesheet" href="{{ static_url('static/tinder.min.css') }}">
  <script src="{{ static_url('static/lib.min.js') }}"></script>
  <script src="{{ static_url('assets/prism/prism.js') }}"></script>
</head>
<body>

{{ content() }}

</body>
</html>
