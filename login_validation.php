<?php
require_once 'configFolder/databaseFunctions/databaseConnect.php';
require_once 'configFolder/sessions.php';
$userForm = $_POST['user'];
$userCheck = checkIfUserExists($userForm);
if($userCheck === false){
  setError('Invalid Username or Password');
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php', true, 301);
}else{
  saveUserLoggedIn($userCheck);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php', true, 301);

}
exit;

