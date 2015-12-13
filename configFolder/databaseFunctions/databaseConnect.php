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


 ?>