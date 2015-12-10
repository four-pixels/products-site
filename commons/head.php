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
   <!--  <link href="/css/main.css" rel="stylesheet" type="text/css"/> -->
    <link rel="stylesheet" href="/styles/main.css">
    <script src="/libs/js/jquery.js"></script>
    <script src="/js/main.js" type="text/javascript"></script>
  </head>
  <body>
    <header id="main_header">
      <div id="logo">
        <a href="index.php"><h1>Some Logo</h1></a>
      </div>
      <nav>
        <ul>
          <li class="<?php if ($_SERVER['PHP_SELF'] === '/index.php') echo 'active'; ?>">
            <a href="index.php"> Home</a>
          </li>
          <li class="<?php if ($_SERVER['PHP_SELF'] === '/x.php') echo 'active'; ?>">
            <a href="x.php">DEVELOPMENT STUDD</a>
          </li>
          <?php if ($session->isLogin() === false): ?>
            <li class="<?php if ($_SERVER['PHP_SELF'] === '/login.php') echo 'active'; ?>">
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
<!--    <section>
      <h2>ADD SERVER VARIABLES</h2>
    <?php var_dump($_SERVER); ?>
    </section>-->