<?php header('HTTP/1.1 404 Not Found'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>404 Not Found</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no"/>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
  <link rel="stylesheet" href="../../../include/Resource/css/library/grid-alpha.css" media="all" />
  <link rel="stylesheet" href="../../../include/Resource/css/library/fonts/inconsolata.css" media="all" />
  <link rel="stylesheet" href="../../../include/Theme/default/css/404.css" media="all" />
</head>
<body>
  <section id="_Here-404">
    <h1>404 Not Found</h1>
  </section>
  <pre>
    <?php echo self::$errno . ': ' . self::$error; ?>
  </pre>
</body>
</html>