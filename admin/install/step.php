<?php
/**
 * return full url 
 * @param string $path
 * @return string full url
 */
function _u($path) {
    echo Request::getFullUrl($path);
}

if (!function_exists('isMobile')) {
    function isMobile() {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return (strpos($agent, 'iphone') || strpos($agent, 'ipad') || strpos($agent, 'android') || strpos($agent, 'midp') || strpos($agent, 'ucweb'));
    }
}

switch (self::$value) {
    case 1:?>
<h3>Welcome to Here.</h3>
<p>Here is distributed under the <a href="<?php _u('license.php'); ?>" target="_blank">MIT</a> license.</p>
<p>This Installer will automatically detect server environment is in line with the minimum configuration requirements. If not meet,  please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>
<?php
break;
    case 2:?>
<section id="here-setting-form">
  <h3>Here Setting</h3>
  <form action="/install.php" method="POST">
    <div class="widget-form-group">
      <!-- Database Host -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-addr"><em>DB Host</em></label>
        <input type="text" id="db-addr" class="widget-form-control" name="host" value="localhost" placeholder="Enter MySQL Host"  required="required"/>
      </div>
      <p class="input-description">You should be able to get this info from your web host, if localhost does not work.</p>
      <!-- Database Port -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-port">DB PORT</label>
        <input type="text" id="db-port" class="widget-form-control" name="port" value="3306" placeholder="Enter MySQL Port" required="required"/>
      </div>
      <p class="input-description">MySQL Server port</p>
      <!-- Database Username -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-user">DB USER</label>
        <input type="text" id="db-user" class="widget-form-control" name="user" value="root"  placeholder="Enter MySQL User" required="required"/>
      </div>
      <p class="input-description">Your MySQL username.</p>
      <!-- Database Password -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pawd">DB PAWD</label>
        <input type="password" id="db-pawd" class="widget-form-control" name="password" placeholder="Enter MySQL Password"<?php if (!isMobile()): ?> autofocus="autofocus"<?php endif; ?> required="required"/>
      </div>
      <p class="input-description">and your MySQL password.</p>
      <!-- Database Name -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-name">DB NAME</label>
        <input type="text" id="db-name" class="widget-form-control" name="database" value="here" placeholder="Enter Database Name" required="required"/>
      </div>
      <p class="input-description">The name of the database you want to run HERE in.</p>
      <!-- Database Pref -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pref">DB PREF</label>
        <input type="text" id="db-pref" class="widget-form-control" name="prefix" value="h_" placeholder="Enter Table Pref" required="required"/>
      </div>
      <p class="input-description">If you want to run multiple Here installations in a single database, change this.</p>
    </div>
  </form>
</section>
<section id="here-responsed" class="widget-hidden">
  <h3 title="fail">Error</h3><h3 title="done">Success</h3>
  <p></p>
</section>
<?php
break;
    case 3:?>
<section id="_Here-User-Info">
  <h3>Information needed</h3>
  <section id="_Here-Infomation-Form">
    <h4 class="widget-hidden">Infomation Form</h4>
    <form action="/controller/installer/info" method="POST">
      <div class="widget-form-group">
        <!-- Site Title -->
        <div class="widget-input-group site-title">
          <label class="widget-input-label" for="site-title"><em>Site Title</em></label>
          <input type="text" id="site-title" class="widget-form-control" name="title" placeholder="Enter Site Title"  required="required" autofocus="autofocus"/>
        </div>
        <p class="input-description"></p>
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="username"><em>Username</em></label>
          <input type="text" id="username" class="widget-form-control" name="username" placeholder="Enter Site Username"  required="required"/>
        </div>
        <p class="input-description">Usernames can have only alphanumeric characters, spaces, underscores, hyphens, periods and the @ symbol.</p>
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="password"><em>Password</em></label>
          <input type="text" id="password" class="widget-form-control" name="password" placeholder="Enter Site Password"  required="required"/>
        </div>
        <p class="input-description">You should be able to get this info from your web host, if localhost does not work.</p>
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="email"><em>E-Mail</em></label>
          <input type="text" id="email" class="widget-form-control" name="email" placeholder="Enter Admin E-Mail"  required="required"/>
        </div>
        <p class="input-description">You should be able to get this info from your web host, if localhost does not work.</p>
      </div>
    </form>
  </section>
  <section id="here-responsed" class="widget-hidden">
    <h3 title="fail">Error</h3><h3 title="done">Success</h3>
    <p></p>
  </section>
</section>
<?php
break;
    case 4:?>
<section id="here-install-complete">
  <h3>Install Success</h3>
  <section id="here-install-complete-msg">
    <h4 class="widget-hidden">Install Success Tips</h4>
    <p class="widget-strong">Here has been installed!</p>
    <section id="here-admin-account">
      <h5 class="widget-hidden">Admin Account</h5>
      <table class="widget-table">
        <tbody>
          <tr><td>Username</td><td>ShadowMan</td></tr>
          <tr><td>Password</td><td>Your chosen password.</td></tr>
        </tbody>
      </table>
    </section>
  </section>
</section>
<?php
    default: exit;
} ?>