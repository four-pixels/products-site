<?php
require_once 'session/SessionManager.php';
require_once 'database/Database.php';
$session = new FourPixels\Session\SessionManager();
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>Bikes</title>
    <link href="/css/animate.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/normalize.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header id="main_header">
      <div id="logo">
        <a href="index.php"><h1>Some Logo</h1></a>
      </div>
      <nav>
        <ul>
          <li>
            <a href="index.php"> Home</a>
          </li>
          <li>
            <a href="registration.php">Registration</a>
          </li>
          <?php if ($session->isLogin() === false): ?>
            <li>
              <a href="login.php">Login</a>
            </li>
          <?php endif; ?>
          <?php if ($session->isLogin() === true): ?>
            <li>
              <a href="logout.php">Logout</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>