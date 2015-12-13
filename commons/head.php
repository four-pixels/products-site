<?php require_once 'configFolder/databaseFunctions/databaseConnect.php'; ?>
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
   <link href='https://fonts.googleapis.com/css?family=Archivo+Black|Source+Sans+Pro:400,300,700|Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/styles/main.css">
    <script src="/libs/js/jquery.js"></script>
    <script src="/js/main.js" type="text/javascript"></script>
  </head>
  <body>
    <header id="main_header">
      <nav id="main-nav">
        <ul>
          <li class="<?php if ($_SERVER['PHP_SELF'] === '/index.php') echo 'active'; ?>">
            <a href="index.php"> Home</a>
          </li>
          <li class="<?php if ($_SERVER['PHP_SELF'] === '/x.php') echo 'active'; ?>">
            <a href="x.php">DEVELOPMENT STUDD</a>
          </li>
          <li><a href="#">Cart</a></li>
            <li class="<?php if ($_SERVER['PHP_SELF'] === '/login.php') echo 'active'; ?>">
              <a href="login.php">Login</a>
            </li>       
            <li>
              <a href="logout.php">Logout</a>
            </li>
        </ul>
      </nav>
    </header>