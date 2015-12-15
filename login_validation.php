<?php
require 'configFolder/databaseFunctions/databaseConnect.php';
$userForm = $_POST['user'];
$userCheck = checkIfUserExists($userForm);
if($userCheck){
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php', true, 301);
}else{
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php', true, 301);
}
exit;

require_once 'database/Database.php';
require_once 'session/SessionManager.php';
$db = new FourPixels\Database\Database();
$userForm = $_POST['user'];
$userResult = $db->getUserByPasswordAndUsernameOrEmail($userForm['password'], $userForm['username']);
$session = new FourPixels\Session\SessionManager();
if ($userResult['hasError'] !== '') {
  $error = $userResult['hasError'];
  $session->setFlashMessage($error);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php', true, 301);
  exit; // THIS WILL STOP PHP to execute any code below this like
} else {
  $session->destroy(); //ERASE if something wass in the SESSION to allow a new one
  $session = new FourPixels\Session\SessionManager();
  $session->setSession($userResult['result']);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php', true, 301);
  exit; // THIS WILL STOP PHP to execute any code below this like
}