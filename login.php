<?php include 'commons/head.php'; ?>
<?php $error = $session->getFlashMessage(); ?>
<style type="text/css">
  body {
    height: 100vh;
    overflow: hidden;
    width: 100% !important;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
  }
  .section-video{
    height: 135vh;
    position: relative;
    top: -18vh;
  }
  .video-overlay {
    background: url(/images/dot.png) rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 34;
    opacity: 0.7;
  }
</style>
<section id="login-registration">

  <div id="back">
    <div class="backRight">
      <div class="video-overlay"></div> 
    </div>
    <div class="backLeft">
      <video class="section-video"  autoplay="" loop="" preload="none" src="/video/video.mp4" >
        <!-- MP4 source must come first for iOS -->
        <source type="video/mp4" src="/video/video.mp4">
        <!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
      </video>
      <div class="video-overlay"></div> 
    </div>
  </div>

  <div id="slideBox">
    <div class="topLayer">
      <div class="left">
        <div class="content">
          <h2>Sign Up</h2>
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
            <button id="goLeft" type="button" class="off">Login</button>
            <button type="submit">Sign up</button>
          </form>
          <?php if (!is_null($error) && $error !== 'Invalid Username or Password'): ?> 
            <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="right">
        <div class="content">
          <h2>Login</h2>
          <form action="login_validation.php" method="POST">
            <div class="form-group">
              <label class="control-label required" for="user_username">Username or email</label>
              <input id="user_username" type="text" name="user[username]" required="required" />
            </div>
            <div class="form-group">
              <label class="control-label required" for="user_password">Password</label>
              <input id="user_password" type="password" name="user[password]" required="required" />
            </div>
            <button id="goRight" type="button" class="off">Sign Up</button>
            <button id="login" type="submit">Login</button>
          </form>
          <?php if (!is_null($error) && $error === 'Invalid Username or Password'): ?> 
            <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>


        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function () {
    $('#goRight').on('click', function () {
      $('#slideBox').animate({
        'marginLeft': '0'
      });
      $('.topLayer').animate({
        'marginLeft': '100%'
      });
    });
    $('#goLeft').on('click', function () {
      $('#slideBox').animate({
        'marginLeft': '50%'
      });
      $('.topLayer').animate({
        'marginLeft': '0'
      });
    });
    $("video").prop('muted', true); //mute
<?php if (!is_null($error) && $error !== 'Invalid Username or Password'): ?>
      $('#goRight').trigger('click');
<?php endif; ?>
  });
</script>

<?php include 'commons/footer.php'; ?>


