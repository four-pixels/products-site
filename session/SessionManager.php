<?php

namespace FourPixels\Session;

/**
 * Description of SessionManager
 *
 * @author Erick
 * @author Rene
 */
class SessionManager  {

  public function __construct() {
    session_start();
    return $this;
  }

  public function setSession($user) {
    $_SESSION['fourpixels']['id'] = $user['id'];
    $_SESSION['fourpixels']['username'] = $user['username'];
    return $this;
  }

  public function isLogin() {
    if (isset($_SESSION['fourpixels'])) {
      return true;
    }
    return false;
  }

  public function getUsername() {
    if ($this->isLogin()) {
      return $_SESSION['fourpixels']['username'];
    }
    return false;
  }

  public function getUserId() {
    if ($this->isLogin()) {
      return $_SESSION['fourpixels']['id'];
    }
    return false;
  }

  public function destroy() {
    session_destroy();
    return $this;
  }

}
