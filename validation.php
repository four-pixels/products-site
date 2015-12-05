<?php

require_once  'database/Database.php';
include 'commons/head.php';
$userRegistrationForm = $_POST['user'];
$db = new \FourPixels\Database\Database();
$result = $db->createUser($userRegistrationForm);
if ($result['hasError'] !== '') {
  echo 'handle Error' . $result['hasError'];
} else {
  echo 'REDIRECT USER TU THE PAGE HE WAS OR TO INDEX.PHP';
}

include 'commons/footer.php';
