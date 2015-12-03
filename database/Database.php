<?php

namespace database;

class Database {

  protected static $connection;
  private $databaseCreated = true;

  public function __construct() {
    $this->createIfNotExist();
  }

  private function createIfNotExist() {
    $this->connect();
    if (!$this->databaseCreated) { // IF FALSE THE CREATE THE DATABASE AND TABLE AND INSERTS
      $secuenceCreateSQL = [
          //CREATE DATABASE --> https://dev.mysql.com/doc/refman/5.5/en/create-database.html
          'CREATE SCHEMA IF NOT EXISTS shopping DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci',
          //CREATE TABLES --> https://dev.mysql.com/doc/refman/5.5/en/create-table.html
          'CREATE TABLE IF NOT EXISTS shopping.user (
                id INT NOT NULL AUTO_INCREMENT,
                firstname VARCHAR(45) NOT NULL,
                lastname VARCHAR(45) NOT NULL,
                username VARCHAR(45) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(128) NOT NULL,
                PRIMARY KEY (id)); ',
          'CREATE TABLE IF NOT EXISTS shopping.product (
                id INT NOT NULL AUTO_INCREMENT,
                productname VARCHAR(45) NOT NULL,
                description TEXT NOT NULL,
                price FLOAT NOT NULL,
                quantity INT NOT NULL,
                PRIMARY KEY (id));',
          'CREATE TABLE IF NOT EXISTS shopping.image (
                id INT NOT NULL AUTO_INCREMENT,
                title VARCHAR(45) NOT NULL,
                featured TINYINT(1) NOT NULL DEFAULT 0,
                path VARCHAR(255) NOT NULL,
                product_id INT NOT NULL,
                PRIMARY KEY (id),
                INDEX fk_image_product1_idx (product_id ASC),
                CONSTRAINT fk_image_product1
                FOREIGN KEY (product_id)
                REFERENCES shopping.product (id)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);'
      ];
      foreach ($secuenceCreateSQL as $sqlString) {
        $result = $this->executeSQL($sqlString);
        if ($result !== true) {
          die("Error Creating the Database: " . $this->error());
          break;
        }
      }

      $secuenceUserInsertsSQL = [//INSER USERS
          "INSERT INTO 
                  shopping.user 
                SET 
                  firstname='Rene',
                  lastname='Ramirez',
                  username='reneszabo',
                  password='rene',
                  email='rene@gmail.com';",
          "INSERT INTO 
                  shopping.user 
                SET 
                  firstname='Erick',
                  lastname='Hernandez',
                  username='ehz',
                  password='erick',
                  email='erick@gmail.com';"
      ];
      foreach ($secuenceUserInsertsSQL as $sqlString) {
        $result = $this->executeSQL($sqlString);
        if ($result !== true) {
          die("Error Creating the Database: " . $this->error());
          break;
        }
      }

      $secuenceProductInsertsSQL = [
          "INSERT INTO 
            shopping.product 
          (
            productname, 
            description, 
            price, 
            quantity
          ) 
          VALUES 
          ( 
            'BikeName1', 
            'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do 
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
            aliquip ex ea commodo consequat. Duis aute irure dolor in 
            reprehenderit in voluptate velit esse cillum dolore eu fugiat 
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
            sunt in culpa qui officia deserunt mollit anim id est laborum.\n', 
            '2500', 
            '5'
          );",
          "INSERT INTO 
            shopping.product 
          (
            productname, 
            description, 
            price, 
            quantity
          ) 
          VALUES 
          (
            'BikeName2', 
            'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
            Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
            nec luctus magna felis sollicitudin mauris. Integer in mauris eu 
            nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. 
            Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu 
            tempor congue, eros est euismod turpis, id tincidunt sapien risus a 
            quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
            malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, 
            consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, 
            felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. 
            Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. 
            Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. 
            Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. 
            In hac habitasse platea dictumst.\n', 
            '1200', 
            '6'
          );",
          "INSERT INTO 
            shopping.product 
          (
            productname, 
            description, 
            price, 
            quantity
          ) 
          VALUES 
          (
            'BikeName3', 
            'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
            Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
            nec luctus magna felis sollicitudin mauris. Integer in mauris eu 
            nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. 
            Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu 
            tempor congue, eros est euismod turpis, id tincidunt sapien risus a 
            quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
            malesuada nulla a mi.\n', 
            '1200', 
            '6'
          );",
          "INSERT INTO 
            shopping.product 
          (
            productname, 
            description, 
            price, 
            quantity
          ) 
          VALUES 
          (
            'BikeName4', 
            'Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
            malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, 
            consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, 
            felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. 
            Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. 
            Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. 
            Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. 
            In hac habitasse platea dictumst.\n', 
            '1200', 
            '6'
          );"
      ];
      foreach ($secuenceProductInsertsSQL as $sqlString) {
        $result = $this->executeSQL($sqlString);
        var_dump(mysqli_insert_id($this->connect()));
        if ($result !== true) {
          die("Error Creating the Database: " . $this->error());
          break;
        }
      }

      $this->closeConnection();
    }
  }

  /**
   * Connect to the database
   * 
   * @return bool false on failure / mysqli MySQLi object instance on success
   */
  private function connect() {
    // Try and connect to the database
    if (!isset(self::$connection)) {
      // Load configuration as an array. Use the actual location of your configuration file
      // Put the configuration file outside of the document root
      $config = parse_ini_file('config.ini');
      self::$connection = new \mysqli('localhost', $config['username'], $config['password'], $config['dbname']);
      //If conection error just create the data base
      if (self::$connection->connect_error) {
        self::$connection = new \mysqli('localhost', $config['username'], $config['password']);
        if (self::$connection->connect_error) {
          die('Connect Error (' . self::$connection->connect_errno . ') ' . self::$connection->connect_error);
        }
        $this->databaseCreated = false;
      }
    }
    // If connection was not successful, handle the error
    if (self::$connection === false) {
      // Handle error - notify administrator, log to a file, show an error screen, etc.

      return false;
    }
    return self::$connection;
  }

  /**
   * Query the database
   *
   * @param $query The query string
   * @return mixed The result of the mysqli::query() function
   */
  private function query($query) {
    // Connect to the database
    /* @var $connection \mysqli */
    $connection = $this->connect();
    // Query the database
    $result = $connection->query($query);
    return $result;
  }

  /**
   * Opens a connection, Execute sql, close connection and return rows. 
   *
   * @param $query The query string
   * @return bool False on failure / array Database rows on success
   */
  public function executeSQL($query) {
    $rows = array();
    $result = $this->query($query);
    var_dump($result);
    if ($result === false) {
      return false;
    } else if ($result === true) {
      return true; // NOT A SELECT QUERY
    }
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  /**
   * Fetch the last error from the database
   * 
   * @return string Database error message
   */
  public function error() {
    $connection = $this->connect();
    return $connection->error;
  }

  /**
   * Quote and escape value for use in a database query
   *
   * @param string $value The value to be quoted and escaped
   * @return string The quoted and escaped string
   */
  public function quote($value) {
    $connection = $this->connect();
    return "'" . $connection->real_escape_string($value) . "'";
  }

  private function closeConnection() {
    if (self::$connection === false) {
      // Handle error - notify administrator, log to a file, show an error screen, etc.
      return false;
    } else {
      mysqli_close(self::$connection);
      self::$connection = null;
    }
  }

  public function createUser($user) {
    $sql = "INSERT INTO 
                  shopping.user (firstname,lastname,username,password,email)
            VALUES
                  (" .
            $this->quote($user["firstname"]) . "," .
            $this->quote($user["lastname"]) . "," .
            $this->quote($user["username"]) . "," .
            $this->quote($user["password"]) . "," .
            $this->quote($user["email"]) .
            ");";
    $resuelt = $this->executeSQL($sql);
    var_dump($resuelt);
    var_dump($this->error());
  }

}
