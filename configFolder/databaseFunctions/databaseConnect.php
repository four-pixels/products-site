<?php 
  
  require_once 'configFolder/sessions.php';
  
  function connect(){
    $link = new \mysqli('localhost', 'root', 'root', 'shopping');
    // print "Successfully connected. \n";
    return $link;
  }

  function disconnect($l){
    mysqli_close($l);
  }



  function select($tableName){
    $link = connect();
    $result = $link->query("SELECT * from $tableName");
    $rows = [];
    while($row = $result->fetch_assoc()){
    $rows[] = $row;
    }
    disconnect($link);
    return $rows;
  }

  function insertNewUser($user){
    $link = connect();
    $result = $link->query("INSERT INTO user (firstname, lastname, username, password, email) 
                            VALUES (".sanitize($link, $user['firstname']).",
                                    ".sanitize($link, $user['lastname']).",
                                    ".sanitize($link, $user['username']).",
                                    ".sanitize($link, $user['password']).",
                                    ".sanitize($link, $user['email']).")
                                    ");
  
    if($link->error !== ''){
      $errorMsgArray = explode("'", $link->error);
      setError($errorMsgArray[1].' is in use. Please use another '.$errorMsgArray[3]);
      disconnect($link);
      return false;
    }
    disconnect($link);
    return true;
  }

  function checkIfUserExists($user){
    $link = connect();
    $result = select("user where username =".sanitize($link, $user['username'])." and password = ".sanitize($link, $user['password']));
    if (count($result) == 1) {
      return $result[0];
    }
    return false;
  }

  function sanitize($link, $value){
    return "'" . $link->real_escape_string($value) . "'";
  }


 ?>