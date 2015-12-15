<?php 


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
    disconnect($link);
    return false;
  }

  function checkIfUserExists($user){
    $link = connect();
    $result = select("user where username =".sanitize($link, $user['username'])." and password = ".sanitize($link, $user['password']));
    if (count($result) == 1) {
      return true;
    }
    return false;
  }

  function sanitize($link, $value){
    return "'" . $link->real_escape_string($value) . "'";
  }


 ?>