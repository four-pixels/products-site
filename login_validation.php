<?php

require_once 'database/Database.php';
require_once 'session/SessionManager.php';
$db = new FourPixels\Database\Database();
$userForm = $_POST['user'];
$userResult = $db->getUserByPasswordAndUsernameOrEmail($userForm['password'], $userForm['username']);
if ($userResult['hasError'] !== '') {
  $error = $userResult['hasError'];
  var_dump($error); //Handle Error - TELL HIM SOMTHING;
} else {
  $session = new FourPixels\Session\SessionManager();
  $session->destroy(); //ERASE if something wass in the SESSION to allow a new one
  $session = new FourPixels\Session\SessionManager();
  $session->setSession($userResult['result']);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php', true, 301);
  exit; // THIS WILL STOP PHP to execute any code below this like
}