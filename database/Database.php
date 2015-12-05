<?php

namespace FourPixels\Database;

/**
 * Description of Database
 * 
 * The Database Class has all the functions to manage the Database, functions
 * like connect, close, executeQuery, quote.
 * 
 * @author Rene
 * @author Erick
 */
class Database {

  protected static $connection;
  private $databaseCreated = true;

  /**
   * The constructor will check if the database is created.
   * It will check by calling the function createIdNotExist()
   * 
   * @return void 
   */
  public function __construct() {
    $this->createIfNotExist();
  }

  /**
   * This function checks the global variable databaseCreated 
   * If the variable is FALSE than it will:
   * <ul>
   *  <li>CREATE DATABASE</li>
   *  <li>CREATE TABLE</li>
   *  <li>INSERT USERS</li>
   *  <li>INSERT PRODUCTS</li>
   *  <li>INSERT IMAGES FOR PRODUCTS</li>
   * </ul>
   */
  private function createIfNotExist() {
    $this->connect();
    if (!$this->databaseCreated) {
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
          die("Error Creating the Database or Table: " . $this->error());
          break;
        }
      }
      $secuenceUserInsertsSQL = [
          [
              'firstname' => 'Rene',
              'lastname' => 'Ramirez',
              'username' => 'reneszabo',
              'password' => 'rene',
              'email' => 'rene@gmail.com'
          ],
          [
              'firstname' => 'Erick',
              'lastname' => 'Hernandez',
              'username' => 'ehz',
              'password' => 'erick',
              'email' => 'erick@gmail.com'
          ]
      ];
      foreach ($secuenceUserInsertsSQL as $arrayProperties) {
        $result = $this->createUser($arrayProperties);
        if ($result['hasError'] !== '') {
          die("Error Inserting User into the Database: " . $this->error());
          break;
        }
      }
      $secuenceProductInsertsSQL = [
          [
              'productname' => 'BikeName1',
              'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do 
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
            aliquip ex ea commodo consequat. Duis aute irure dolor in 
            reprehenderit in voluptate velit esse cillum dolore eu fugiat 
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
            sunt in culpa qui officia deserunt mollit anim id est laborum.\n',
              'price' => '2500',
              'quantity' => '5'
          ],
          [
              'productname' => 'BikeName2',
              'description' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
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
              'price' => '1200',
              'quantity' => '6'
          ],
          [


              'productname' => 'BikeName3',
              'description' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
            Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
            nec luctus magna felis sollicitudin mauris. Integer in mauris eu 
            nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. 
            Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu 
            tempor congue, eros est euismod turpis, id tincidunt sapien risus a 
            quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
            malesuada nulla a mi.\n',
              'price' => '1200',
              'quantity' => '6'
          ],
          [


              'productname' => 'BikeName4',
              'description' => 'Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
            malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, 
            consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, 
            felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. 
            Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. 
            Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. 
            Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. 
            In hac habitasse platea dictumst.\n',
              'price' => '1200',
              'quantity' => '6'
          ]
      ];
      foreach ($secuenceProductInsertsSQL as $arrayProperties) {
        $result = $this->createProduct($arrayProperties);
        var_dump($result);
        if ($result['hasError'] !== '') {
          die("Error Inserting Product into the Database: " . $this->error());
          break;
        }

        $idCreated = $result['idCreated'];
        switch ($idCreated) {
          case 1:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => false,
                    'path' => 'image1.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => true,
                    'path' => 'image2.png',
                    'product_id' => $idCreated
                ]
            ];
            break;
          case 2:
            $secuenceImages = [
                [
                    'title' => 'title2',
                    'featured' => true,
                    'path' => 'image2.png',
                    'product_id' => $idCreated
                ]
            ];
            break;
          case 3:
            $secuenceImages = [
                [
                    'title' => 'title4',
                    'featured' => true,
                    'path' => 'image4.png',
                    'product_id' => $idCreated
                ]
            ];
            break;
          case 4:
            $secuenceImages = [
                [
                    'title' => 'title5',
                    'featured' => true,
                    'path' => 'image5.png',
                    'product_id' => $idCreated
                ]
            ];
            break;
        }
        foreach ($secuenceImages as $arrayImagesProperties) {
          $resultImage = $this->createImageProduct($arrayImagesProperties);
          if ($resultImage['hasError'] !== '') {
            die("Error Inserting Image into the Database: " . $this->error());
            break;
          }
        }
      }
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
   * Opens a connection, Execute sql and return rows. 
   *
   * @param $query The query string
   * @return bool False on failure / array Database rows on success
   */
  public function executeSQL($query) {
    $rows = array();
    $result = $this->query($query);
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

  public function closeConnection() {
    if (self::$connection === false) {
      // Handle error - notify administrator, log to a file, show an error screen, etc.
      return false;
    } else {
      mysqli_close(self::$connection);
      self::$connection = null;
    }
  }

  /* --- USER FUNCTIONS ------------------------------------------------- --- */

  /**
   * Execute a select on the Database: 
   * <p><code>select * from user</code></p>
   * @return array ['result'=>array,'hasError'=>string]
   */
  public function getUserAll() {
    $sql = 'select * from user';
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $return = ['result' => $result, 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /**
   * Execute a select on the Database: 
   * <p><code>select * from user</code></p>
   * @return array ['result'=>array,'hasError'=>string]
   */
  public function getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail) {
    $sql = "select * from shopping.user as u where (u.username=" . $this->quote($usernameOrEmail) . " or u.email=" . $this->quote($usernameOrEmail) . ") and u.password=" . $this->quote($password) . " limit 1";
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $return = ['result' => $result, 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /**
   * Creates a Insert of a User
   * <p><code>INSERT INTO 
   * shopping.user (firstname,lastname,username,password,email)
   * VALUES
   * (string,string,string,string,string)
   * </code></p>
   * @param array [firstname=>string ,lastname=>string ,username=>string ,password=>string ,email=>string]
   * @return array ['result'=>array,idCreated=>int ,'hasError'=>string]
   */
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
    $return = ['result' => $resuelt, 'idCreated' => mysqli_insert_id($this->connect()), 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /* --- PRODUCT FUNCTIONS ---------------------------------------------- --- */

  /**
   * Creates a Insert of a Product
   * <p><code>INSERT INTO 
   * shopping.product (productname, description, price, quantity)
   * VALUES
   * (string,string,float,int)
   * </code></p>
   * @param array [productname=>string ,description=>string ,price=>string ,quantity=>string]
   * @return array ['result'=>array,idCreated=>int ,'hasError'=>string]
   */
  public function createProduct($product) {
    $sql = "INSERT INTO 
                  shopping.product (productname, description, price, quantity)
            VALUES
                  (" .
            $this->quote($product["productname"]) . "," .
            $this->quote($product["description"]) . "," .
            $this->quote($product["price"]) . "," .
            $this->quote($product["quantity"]) .
            ");";
    var_dump($sql);
    $resuelt = $this->executeSQL($sql);
    $return = ['result' => $resuelt, 'idCreated' => mysqli_insert_id($this->connect()), 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /**
   * Execute a select on the Database: 
   * <p><code>select * from shopping.product</code></p>
   * @return array ['result'=>array,'hasError'=>string]
   */
  public function getProductAll() {
    $sql = 'select * from shopping.product';
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $return = ['result' => $result, 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /**
   * Execute a select on the Database: 
   * <p><code>select * from shopping.image where product_id= $idProduct</code></p>
   * @param int $idProduct
   * @return array ['result' => array, 'hasError' => string]
   */
  public function getProductImages($idProduct) {
    $sql = 'select * from shopping.image where product_id=' . $idProduct;
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $return = ['result' => $result, 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

  /* --- IMAGE PRODUCT FUNCTIONS ---------------------------------------- --- */

  /**
   * Creates a Insert of a Product
   * <p><code>INSERT INTO 
   * shopping.image (title, featured, path, product_id)
   * VALUES
   * (string,boolean,string,int)
   * </code></p>
   * @param array [title=>string ,featured=>boolean ,path=>string ,product_id=>int]
   * @return array ['result'=>array,idCreated=>int ,'hasError'=>string]
   */
  public function createImageProduct($image) {
    $sql = "INSERT INTO 
                  shopping.image (title, featured, path, product_id)
            VALUES
                  (" .
            $this->quote($image["title"]) . "," .
            $this->quote($image["featured"]) . "," .
            $this->quote($image["path"]) . "," .
            $this->quote($image["product_id"]) .
            ");";
    var_dump($sql);
    $resuelt = $this->executeSQL($sql);
    $return = ['result' => $resuelt, 'idCreated' => mysqli_insert_id($this->connect()), 'hasError' => $this->error()];
    $this->closeConnection();
    return $return;
  }

}
