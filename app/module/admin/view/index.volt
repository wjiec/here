<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ get_title(false) ~ ' - ' ~ config.blog.name }}</title>
  <link rel="stylesheet" href="{{ static_url('css/style.css') }}">
  <link rel="stylesheet" href="{{ static_url('css/admin.css') }}">
</head>
<body>

{{ content() }}

</body>
</html>
