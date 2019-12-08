<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
  <title>{{ get_title(false) ~ ' - ' ~ config.blog.name }}</title>
  <link rel="stylesheet" href="{{ static_url('css/style.css') }}">
  <link rel="stylesheet" href="{{ static_url('css/tinder.css') }}">
  <script src="{{ static_url('js/lib.js') }}"></script>
</head>
<body>

{{ content() }}

</body>
</html>
