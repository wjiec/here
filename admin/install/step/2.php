<section id="_Here-Setting-Form">
  <h3>Here Setting</h3>
  <form action="/install.php" method="POST">
    <div class="widget-form-group">
      <!-- Database Host -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-addr"><em>DB Host</em></label>
        <input type="text" id="db-addr" class="widget-form-control" name="db-addr" value="localhost" placeholder="Enter MySQL Host"  required="required"/>
      </div>
      <p class="_Here-Form-Tips">You should be able to get this info from your web host, if localhost does not work.</p>
      <!-- Database Port -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-port">DB PORT</label>
        <input type="text" id="db-port" class="widget-form-control" name="db-port" value="3306" placeholder="Enter MySQL Port" required="required"/>
      </div>
      <p class="_Here-Form-Tips">MySQL Server port</p>
      <!-- Database Username -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-user">DB USER</label>
        <input type="text" id="db-user" class="widget-form-control" name="db-user" value="root"  placeholder="Enter MySQL User" required="required"/>
      </div>
      <p class="_Here-Form-Tips">Your MySQL username.</p>
      <!-- Database Password -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pawd">DB PAWD</label>
        <input type="password" id="db-pawd" class="widget-form-control" name="db-pawd" placeholder="Enter MySQL Password" autofocus="autofocus" required="required"/>
      </div>
      <p class="_Here-Form-Tips">and your MySQL password.</p>
      <!-- Database Name -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-name">DB NAME</label>
        <input type="text" id="db-name" class="widget-form-control" name="db-name" value="here" placeholder="Enter Database Name" required="required"/>
      </div>
      <p class="_Here-Form-Tips">The name of the database you want to run WP in.</p>
      <!-- Database Pref -->
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pref">DB PREF</label>
        <input type="text" id="db-pref" class="widget-form-control" name="db-pref" value="h_" placeholder="Enter Table Pref" required="required"/>
      </div>
      <p class="_Here-Form-Tips">If you want to run multiple WordPress installations in a single database, change this.</p>
    </div>
  </form>
</section>
<section id="_Here-Setting-Error" class="widget-hidden">
  <h3 id="check-error">!!! Error</h3>
  <p></p>
</section>