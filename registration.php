<html>
  <head>
    <title>Registration Page</title>
  </head>
  <body>
    <form id="UserRegistration" action="validation.php" method="POST" >
      <div class="form-group">
        <label class="control-label required" for="user_fistname">First name</label>
        <input id="user_fistname" type="text" name="user[firstname]" required="required" />
      </div>
      <div class="form-group">
        <label class="control-label required" for="user_lastname">Last name</label>
        <input id="user_lastname" type="text" name="user[lastname]" required="required" />
      </div>
      <div class="form-group">
        <label class="control-label required" for="user_username">Username</label>
        <input id="user_username" type="text" name="user[username]" required="required" />
      </div>
      <div class="form-group">
        <label class="control-label required" for="user_email">Email</label>
        <input id="user_email" type="email" name="user[email]" required="required" />
      </div>
      <div class="form-group">
        <label class="control-label required" for="user_password">Password</label>
        <input id="user_password" type="password" name="user[password]" required="required" />
      </div>
      <div class="form-group">
        <button type="submit"> Submit</button>
      </div>
    </form>
  </body>
</html>


