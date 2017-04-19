<?php
/**
 * Here Install Guide
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Here Installer Guide</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no"/>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php Theme_Helper::static_url_completion('/static/default/css/library/grid-flex-alpha.css'); ?>" media="all" />
  <link rel="stylesheet" href="<?php Theme_Helper::static_url_completion('/static/install/css/install.css'); ?>" media="all" />
  <script src="<?php Theme_Helper::static_url_completion('/static/default/js/library/here-base.js'); ?>"></script>
  <script src="<?php Theme_Helper::static_url_completion('/static/install/js/installer.js'); ?>"></script>
</head>
<body>
  <header id="here-installer-header" class="flex-container-center">
    <div id="progress" class="widget-progress"></div>
    <h1 class="flex-item-center">Here Installer Guide</h1>
  </header>
  <div id="here-installer-container" class="container">
    <section id="here-install-body" class="flex-container-column-center flex-container-cross-center">
        <div id="here-installer-contents">
          <h3>Welcome to Here.</h3>
          <p>Here is distributed under the <a href="/license" target="_blank">MIT License</a>.</p>
          <p>This installer guide will automatically detect server environment is in line with the minimum configuration requirements. If not meet, please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>
        </div>
        <div id="here-installer-server-detecting">
          <div id="here-installer-sd-status-bar">
            <p class="detect-status-wait">Detecting Server...</p>
          </div>
          <div id="here-installer-sd-result">
            <ul id="here-installer-sd-list">
              <li class="here-installer-sd-item here-installer-sd-item-fail"><p>Python Support</p></li>
              <li class="here-installer-sd-item here-installer-sd-item-success"><p>Apache URL rewrite</p></li>
            </ul>
          </div>
        </div>
        <div id="button-container">
          <button id="here-installer-next-btn" class="widget-btn-default" disabled>Next</button>
        </div>
    </section>
  </div>
  <footer id="here-installer-footer" class="flex-container"></footer>
</body>
</html>
