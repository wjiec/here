<?php
/**
 * Here Installer Guide
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
  <link rel="stylesheet" href="<?php Theme_Helper::static_completion('default', 'css/library/grid-flex-alpha.min.css'); ?>" media="all" />
  <link rel="stylesheet" href="<?php Theme_Helper::static_completion('installer', 'css/installer.min.css'); ?>" media="all" />
  <script src="<?php Theme_Helper::static_completion('default', 'js/library/here-base.js'); ?>"></script>
  <script src="<?php Theme_Helper::static_completion('installer', 'js/installer.js'); ?>"></script>
</head>
<body>
  <header id="here-installer-header" class="flex-container-center">
    <div id="progress" class="widget-progress"></div>
    <h1 class="flex-self-center">Here Installer Guide</h1>
  </header>
  <div id="here-installer-container" class="container">
    <section id="here-install-body" class="flex-container-column-center flex-container-cross-center">
      <?php $step_name = Here_Request::get_parameter('sep'); ?>
      <div id="here-installer-contents">
        <?php if ($step_name == null || $step_name == 'detecting-server'): ?>
        <h3>Welcome to Here</h3>
        <p>Here is distributed under the <a href="<?php Theme_Helper::url_completion('/license'); ?>" target="_blank">MIT License</a>.</p>
        <p>This installer guide will automatically detect server environment is in line with the minimum configuration requirements.
          If not meet, please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>
        <div id="here-installer-server-detecting">
          <div id="here-installer-detect-status-bar">
            <p class="detect-status-wait">Please press >>Start<< to getting detecting server list</p>
          </div>
          <div id="here-installer-detect-result" class="flex-container-column"></div>
        </div>
        <?php elseif ($step_name == 'database-configure'): ?>
        <h3>Database configuration</h3>
        <?php elseif ($step_name == 'admin-configure'): ?>
        <h3>Administrator configuration</h3>
        <?php elseif ($step_name == 'site-configure'): ?>
        <h3>Blogger configuration</h3>
        <?php elseif ($step_name == 'complete-install'): ?>
        <h3>Install completed</h3>
        <?php else: ?>
        <?php Core::router_instance()->emit_error(403); ?>
        <?php endif;?>
      </div>
      <div id="button-container">
        <button id="here-installer-next-btn" class="widget-btn-default">Start</button>
      </div>
    </section>
  </div>
  <footer id="here-installer-footer" class="flex-container"></footer>
</body>
</html>
