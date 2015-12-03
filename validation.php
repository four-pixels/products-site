<?php

include 'database/Database.php';
$userRegistrationForm = $_POST['user'];
$database = new database\Database();
$database->createUser($userRegistrationForm);
var_dump($userRegistrationForm);
