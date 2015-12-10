<section id="_Here-Setting-Form">
  <h3>Here Setting</h3>
  <form action="/install.php" method="POST">
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-addr">DB ADDR</label>
        <input type="text" id="db-addr" class="widget-form-control" name="db-addr" value="localhost" required="required"/>
      </div>
      <p class="_Here-Form-Tips">You should be able to get this info from your web host, if localhost does not work.</p>
    </div>
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-port">DB PORT</label>
        <input type="text" id="db-port" class="widget-form-control" name="db-port" value="3306" required="required"/>
      </div>
      <p class="_Here-Form-Tips">MySQL Server port</p>
    </div>
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-user">DB USER</label>
        <input type="text" id="db-user" class="widget-form-control" name="db-user" value="root" required="required"/>
      </div>
      <p class="_Here-Form-Tips">Your MySQL username.</p>
    </div>
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pawd">DB PAWD</label>
        <input type="password" id="db-pawd" class="widget-form-control" name="db-pawd" placeholder="enter password" autofocus="autofocus" required="required"/>
      </div>
      <p class="_Here-Form-Tips">and your MySQL password.</p>
    </div>
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-name">DB NAME</label>
        <input type="text" id="db-name" class="widget-form-control" name="db-name" value="here" required="required"/>
      </div>
      <p class="_Here-Form-Tips">The name of the database you want to run WP in.</p>
    </div>
    <div class="widget-form-group">
      <div class="widget-input-group">
        <label class="widget-input-label" for="db-pref">DB PREF</label>
        <input type="text" id="db-pref" class="widget-form-control" name="db-pref" value="h_" required="required"/>
      </div>
      <p class="_Here-Form-Tips">If you want to run multiple WordPress installations in a single database, change this.</p>
    </div>
  </form>
</section>