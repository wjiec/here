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
  <link rel="stylesheet" href="<?php Theme_Helper::static_completion('default', 'css/library/grid-flex-alpha.css'); ?>" media="all" />
  <link rel="stylesheet" href="<?php Theme_Helper::static_completion('installer', 'css/installer.css'); ?>" media="all" />
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
          <section id="here-installer-database-configure">
            <form action="/api/v1/installer/database_configure" method="POST">
              <div class="widget-form-group">
                <!-- Database Host -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-host">DB Host</label>
                    <input type="text" id="here-installer-db-host" class="widget-form-control" name="host" value="localhost" placeholder="Database server host"  required="required"/>
                  </div>
                  <p class="input-description">Your should be able to get this info from your web host, if localhost does not work.</p>
                </div>
                <!-- Database Port -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-port">DB PORT</label>
                    <input type="text" id="here-installer-db-port" class="widget-form-control" name="port" value="3306" placeholder="Database server port" required="required"/>
                  </div>
                  <p class="input-description">Your database server port, MySQL default port is 3306.</p>
                </div>
                <!-- Database Username -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-username">DB USER</label>
                    <input type="text" id="here-installer-db-username" class="widget-form-control" name="username" value="root"  placeholder="Database username" required="required"/>
                  </div>
                  <p class="input-description">Your database username, must have permission to create a table.</p>
                </div>
                <!-- Database Password -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-password">DB PASS</label>
                    <input type="password" id="here-installer-db-password" class="widget-form-control" name="password" value="" placeholder="Database password" required="required" autofocus/>
                  </div>
                  <p class="input-description">and your database password</p>
                </div>
                <!-- Database Name -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-name">DB NAME</label>
                    <input type="text" id="here-installer-db-name" class="widget-form-control" name="database" value="here" placeholder="Database name" required="required"/>
                  </div>
                  <p class="input-description">The name of the database if you want to storage all in here.</p>
                </div>
                <!-- Database Pref -->
                <div class="widget-input-group-with-desc">
                  <div class="widget-input-group">
                    <label class="widget-input-label" for="here-installer-db-prefix">DB PREF</label>
                    <input type="text" id="here-installer-db-prefix" class="widget-form-control" name="prefix" value="here_" placeholder="Table name prefix" required="required"/>
                  </div>
                  <p class="input-description">If you want to run multiple Here installations in a single database, change this.</p>
                </div>
              </div>
            </form>
            <div id="here-installer-database-info">
                <h3 id="here-installer-database-info-title" class="widget-hidden">Database server information</h3>
                <p id="here-installer-database-client-info"></p>
                <p id="here-installer-database-server-info"></p>
            </div>
          </section>
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
