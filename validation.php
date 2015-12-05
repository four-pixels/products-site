<?php

include 'database/objects/User.php';
include 'database/Database.php';
include 'commons/head.php';
$userRegistrationForm = $_POST['user'];
$db = new \FourPixels\Database\Database();
var_dump($userRegistrationForm);
$result = $db->createUser($userRegistrationForm);
if ($result['hasError'] !== '') {
  echo 'handle Error' . $result['hasError'];
} else {
  echo 'render success message';
}

include 'commons/footer.php';
