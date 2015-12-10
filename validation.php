<?php

require_once 'database/Database.php';
require_once 'session/SessionManager.php';
$userRegistrationForm = $_POST['user'];
$db = new \FourPixels\Database\Database();
$result = $db->createUser($userRegistrationForm);
$session = new FourPixels\Session\SessionManager();
if ($result['hasError'] !== '') {
  $errorArray = explode("'", $result['hasError']);
  if (isset($errorArray[3]) && ($errorArray[3] === 'email' || $errorArray[3] === 'username')) {
    $session->setFlashMessage($errorArray[1] . " is in use. Please use other " . $errorArray[3] . '.');
  }
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php', true, 301);
  exit; // THIS WILL STOP PHP to execute any code below this like
} else {
  $id = $result['idCreated'];
  $userResult = $db->getUserById($id);
  $session->setSession($userResult['result']);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php', true, 301);
  exit; // THIS WILL STOP PHP to execute any code below this like
}
