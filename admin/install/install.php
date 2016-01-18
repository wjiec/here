<?php
/**
 * HERE Install Program
 * 
 * @package Here
 * @author  ShadowMan
 */

/**
 * return pull url
 * @param string $path
 * @return string full url
 */
function _u($path) {
        echo Request::getFullUrl($path);
}
/**
 * is mobile return true
 * @return boolean
 */
function _m() {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    return (strpos($ua, 'iphone') || strpos($ua, 'ipad') || strpos($ua, 'android') || strpos($ua, 'midp') || strpos($ua, 'ucweb'));
}
// TODO Current PJAX
?><!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Here Installer</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no"/>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
  <!-- style library -->
  <link rel="stylesheet" href="../../include/Resource/css/library/grid-alpha.css" media="all" />
  <!-- Font -->
  <link rel="stylesheet" href="../../include/Resource/css/library/fonts/fira.css" media="all" />
  <link rel="stylesheet" href="../../include/Resource/css/library/fonts/inconsolata.css" media="all" />
  <!-- module style -->
  <link rel="stylesheet" href="../../include/Resource/css/module/install.css" media="all" />
<?php if (_m()): ?>
  <!-- mobile lirary -->
  <script src="../../include/Resource/js/library/mobile/zepto.min.js"></script>
  <script src="../../include/Resource/js/library/mobile/fastclick.min.js"></script>
<?php else: ?>
  <!-- PC library -->
  <script src="../../include/Resource/js/library/jquery-2.1.4.min.js"></script>
<?php endif; ?>
  <script src="../../include/Resource/js/library/jquery.pjax.js"></script>
  <script src="../../include/Resource/js/installer.js"></script>
</head>
<body>
  <div id="_Here-Installer" class="container-fluid">
    <div class="row">
      <section id="_Here-Installer-Header" class="widget-align-vh">
        <h1>Here Installer</h1>
      </section>
      <section id="_Here-Installer-Container" class="widget-container col-xl-6 col-xl-offset-3 col-lg-7 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <h2 class="widget-hidden">Here Installer Guide</h2>
        <div id="_Here-Replace-Container">
          <?php Controller::request('Installer', 'step'); ?>
        </div>
      </section>
      <?php if (!(Controller::request('Installer', 'serverDetect'))): ?>
      <section id="_Here-Server-Env" class="widget-container col-xl-6 col-xl-offset-3 col-lg-7 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <h3 class="widget-hidden">Detect Server Environment</h3>
        <ul class="widget-list">
          <?php Controller::request('Installer', 'failServerDetectList'); ?>
        </ul>
      </section>
    <?php endif; ?>
    </div>
    <div id="_Here-Next-Step" class="row">
      <div id="Btn-Container" class="col-lg-offset-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-16">
        <button id="Next-Step-Btn" class="widget-btn widget-btn-default" value='2'>Next Step</button>
      </div>
    </div>
  </div>
  <footer></footer>
</body>
</html>
