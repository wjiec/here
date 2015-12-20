<section id="_Here-User-Info">
  <h3>Information needed</h3>
  <section id="_Here-Infomation-Form">
    <h4 class="widget-hidden">Infomation-Form</h4>
    <form action="/controller/installer/info" method="POST">
      <div class="widget-form-group">
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="site-title"><em>Site Title</em></label>
          <input type="text" id="site-title" class="widget-form-control" name="site-title" placeholder="Enter Site Title"  required="required" autofocus="autofocus"/>
        </div>
        <p class="_Here-Form-Tips"></p>
        
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="username"><em>Username</em></label>
          <input type="text" id="username" class="widget-form-control" name="username" placeholder="Enter Site Username"  required="required"/>
        </div>
        <p class="_Here-Form-Tips">Usernames can have only alphanumeric characters, spaces, underscores, hyphens, periods and the @ symbol.</p>
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="password"><em>Password</em></label>
          <input type="text" id="password" class="widget-form-control" name="password" placeholder="Enter Site Password"  required="required"/>
        </div>
        <p class="_Here-Form-Tips">You should be able to get this info from your web host, if localhost does not work.</p>
        <!-- Site Title -->
        <div class="widget-input-group">
          <label class="widget-input-label" for="email"><em>E-Mail</em></label>
          <input type="text" id="email" class="widget-form-control" name="email" placeholder="Enter Site E-Mail"  required="required"/>
        </div>
        <p class="_Here-Form-Tips">You should be able to get this info from your web host, if localhost does not work.</p>
      </div>
    </form>
  </section>
</section>