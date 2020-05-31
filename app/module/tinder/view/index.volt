<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ get_title(false) ~ ' - ' ~ 'TODO' }}</title>
  <link rel="stylesheet" href="{{ static_url('assets/prism/prism.css') }}">
  <link rel="stylesheet" href="{{ static_url('static/tinder.min.css') }}">
</head>
<body>

{{ content() }}

<script src="{{ static_url('static/go.min.js') }}"></script>
</body>
</html>
