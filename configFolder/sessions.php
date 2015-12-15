<?php 
  session_start();

  // var_dump($_SESSION);
  // $_SESSION['msg'] = 'hello!';
  // 
  function saveUserLoggedIn($user){
    $_SESSION['username'] = $user['username'];
    $_SESSION['userId'] = $user['id'];
  }

  function isLoggedIn(){
    return isset($_SESSION['username']) ? true:false;
  }

  function destroySession(){
    session_destroy();
  }

  function setError($msg){
    $_SESSION['msg'] = $msg;
  }

  function getError(){
    if(isset($_SESSION['msg'])){
      $msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
      return $msg;
    }
    return null;
  }

 

