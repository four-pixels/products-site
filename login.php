<?php include 'commons/head.php'; ?>
<form action="login_validation.php" method="POST">
  <div class="form-group">
    <label class="control-label required" for="user_username">Username or email</label>
    <input id="user_username" type="text" name="user[username]" required="required" />
  </div>
  <div class="form-group">
    <label class="control-label required" for="user_password">Password</label>
    <input id="user_password" type="password" name="user[password]" required="required" />
  </div>
  <div class="form-group">
    <button type="submit"> Submit</button>
  </div>
</form> 
<?php include 'commons/footer.php'; ?>


