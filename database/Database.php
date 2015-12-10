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
              'productname' => 'AMERICA (MY16)',
              'description' => 'This bike isn’t just built to look a certain way,it’s built to feel a certain way.
The America is engineered around a unique engine so you get a truly authentic ride. One that connects you to Triumph’s long and rich cruiser heritage.
We’re talking about its distinctive, air-cooled parallel-twin that gives you the riding experience you expect from this class but with a very individual British flavour.
Taking classic cruiser appeal and blending it with Triumph reliability and everyday practicality.',
              'price' => '9400',
              'quantity' => '5'
          ],
          [
              'productname' => 'AMERICA LT (MY16)',
              'description' => 'From a cross-town hop to an intercontinental tour, the America LT will take you there in style. Based on the engine, chassis and legendary styling of our America, the LT adds a layer of touring capability and an enviable range of factory fitted extras designed to make those longer distances a breeze. All the while maintaining the traditional deep chrome and polished detailing demanded of a classic cruiser, of course.',
              'price' => '10900',
              'quantity' => '6'
          ],
          [
              'productname' => 'SPEEDMASTER (MY16)',
              'description' => "Long, low, blacked out and mean, the Speedmaster echoes the hot-rod cruiser theme but adds a very British spin with some classic Triumph parallel twin power.
Built to be an engaging entry level bike that's also ideal for riders moving to their first big bike the Speedmaster has the zest and handling to keep experienced riders happy too.
Everything about it is laid back and easy. The low rider look is a classic one reflecting the style of homebuilt hot-rods on both sides of the Atlantic.
But the soul of any bike is its engine. And that’s where the Speedmaster stands out even more, with an air-cooled twin that is steeped in our long and colourful heritage.
All this means you have a highly capable motorcycle that has a great feel and delivers satisfying performance every single day.
That’s what makes it such good value for money.",
              'price' => '9400',
              'quantity' => '10'
          ],
          [
              'productname' => 'ROCKET III ROADSTER',
              'description' => "With the world’s biggest production motorcycle engine the latest Rocket III Roadster builds on the huge performance of the original Rocket III but now with even more torque.
The 2.3 litre, three-cylinder engine is designed to be an arm-wrenching thrill to ride, yet easy and unintimidating too, despite its thunderous roar. Its sweet handling chassis, rigid frame and sophisticated suspension gives you the confidence to sweep through corners and change direction with an agility that belies this Roadsters size. 
The latest Rocket III features blackened components including radiator cowls, rear mudguard rails, airbox cover, fork protectors, and mirrors giving our Roadster an even more menacing look.
There's nothing else like it out there, not to look at, nor to ride.",
              'price' => '17300',
              'quantity' => '12'
          ],
          [
              'productname' => 'ROCKET III TOURING',
              'description' => "NO DESCRIPTION ON PAGE",
              'price' => '19500',
              'quantity' => '5'
          ],
          [
              'productname' => 'THUNDERBIRD',
              'description' => "
Laid back and relaxed, the Thunderbird is exactly the way a cruiser should be.
But, on top of that, Triumph engineering has added superior performance and handling without ever diluting what the Thunderbird is all about.
The engine itself is unique in its class, a classic Triumph parallel twin. And the styling is pure cruiser with sweeping lines, low seat and high bars.
But like any Triumph it's highly practical too, and perfectly feasible as an everyday commuter. A long, low, fat-tyred, chromed up, everyday commuter.",
              'price' => '0',
              'quantity' => '3'
          ],
          [
              'productname' => 'THUNDERBIRD STORM',
              'description' => "We squeezed 102cc more from the muscle-bound parallel twin engine so that it packs an even bigger punch. Still laid-back but underpinned by serious power and the best handling in the class. This is a cruiser with a dark side.",
              'price' => '16800',
              'quantity' => '7'
          ],
          [
              'productname' => 'THUNDERBIRD COMMANDER',
              'description' => "A strong, willing engine, refined chassis, powerful looks and broad riding position give our new Thunderbird Commander the power and presence to dominate any road. Based on our original Thunderbird, the Commander easily impresses riders and onlookers with its classic cruiser style, premium feel and the world’s largest capacity parallel twin engine. Being a Triumph, it’s a cruiser that also gives you day-long comfort, practicality, character and, on top of all that, superb handling. There’s no compromise here.",
              'price' => '17600',
              'quantity' => '4'
          ],
          [
              'productname' => 'THUNDERBIRD LT',
              'description' => "Its distinctive, charismatic parallel twin engine and class-leading chassis can turn every journey into the trip of a lifetime. The 2014 Thunderbird LT will transport you with effortless power and style to new adventures with the easy-going, laid-back vibe of a premium classic touring cruiser.",
              'price' => '18600',
              'quantity' => '8'
          ]
      ];
      foreach ($secuenceProductInsertsSQL as $arrayProperties) {
        $result = $this->createProduct($arrayProperties);
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
                    'featured' => true,
                    'path' => 'america-my16/MK6MY14AmericaDBDARHS1.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'america-my16/MK6_MY14_America_PR_RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'america-my16/27-America-15-6.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'america-my16/27-America-15-2.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title5',
                    'featured' => false,
                    'path' => 'america-my16/27-America-15-14.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title6',
                    'featured' => false,
                    'path' => 'america-my16/27-America-15-11.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title7',
                    'featured' => false,
                    'path' => 'america-my16/27-America-15-10.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 2:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'america-lt-my-16/MKX_MY14_America-LT_JIJM_RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'america-lt-my-16/27-America-LT-15-1.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'america-lt-my-16/27-America-LT-15-12.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'america-lt-my-16/27-America-LT-15-20.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title5',
                    'featured' => false,
                    'path' => 'america-lt-my-16/27-America-LT-15-7.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 3:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'speedmaster-my-16/ML6_MY14_LS_Speedmaster_RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/ML6_MY14_PG_Speedmaster_RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/27-Speedmaster-15-13.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/27-Speedmaster-15-4.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title5',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/27-Speedmaster-15-5.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title6',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/27-Speedmaster-15-8.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title7',
                    'featured' => false,
                    'path' => 'speedmaster-my-16/27-speedmaster-15-3.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 4:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'rocket-iii-roadster/XJ2_MY13_Rocket-III-Roadster_PD_RHS_3000px.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'rocket-iii-roadster/XJ2_MY13_Rocket-III-Roadster_PR_RHS_3000px.png',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 5:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'rocket-iii-touring/XH2MY13RocketIIITouringCXPRrhsAllMarkets1.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'rocket-iii-touring/XH2_MY13_Rocket_III_Touring_PR-rhs-AllMarkets.png',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 6:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'thunderbird/BC_MY11_Thunderbird_JDPR_rhs_3000px.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'thunderbird/BC_MY14_Thunderbird_CDMO_rhs.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird/BC_MY14_Thunderbird_PR_rhs.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird/27-Thunderbird-15-Gallery-1.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title5',
                    'featured' => false,
                    'path' => 'thunderbird/27-Thunderbird-15-Gallery-2.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title6',
                    'featured' => false,
                    'path' => 'thunderbird/27-Thunderbird-15-Gallery-3.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 7:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'thunderbird-storm/BK_MY11_Thunderbird-Storm_PG_RHS_3000px.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'thunderbird-storm/MY16ThunderbirdStormCDrhs.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird-storm/27-Thunderbird-Storm-15-Gallery-4.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird-storm/27-Thunderbird-Storm-15-Gallery-5.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird-storm/27-Thunderbird-Storm-15-Gallery-6.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 8:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'thunderbird-commander/BD-Black.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'thunderbird-commander/BD_MY15_Thunderbird_Commander_PG-RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird-commander/MY16ThunderbirdCommanderDCMArhs3.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-commander/27-Thunderbird-Commander-15-12.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title5',
                    'featured' => false,
                    'path' => 'thunderbird-commander/27-Thunderbird-Commander-15-13.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title6',
                    'featured' => false,
                    'path' => 'thunderbird-commander/27-Thunderbird-Commander-15-2.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title7',
                    'featured' => false,
                    'path' => 'thunderbird-commander/27-Thunderbird-Commander-15-3.jpg',
                    'product_id' => $idCreated
                ],
            ];
            break;
          case 9:
            $secuenceImages = [
                [
                    'title' => 'title1',
                    'featured' => true,
                    'path' => 'thunderbird-lt/BF-THUNDERBIRD-LT-BASE-RHS-CDPR.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title2',
                    'featured' => false,
                    'path' => 'thunderbird-lt/BF_THUNDERBIRD_LT_PG_RHS.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title3',
                    'featured' => false,
                    'path' => 'thunderbird-lt/MY16ThunderbirdLTNWPRrhs2.png',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-lt/27-Thunderbird-LT-15-10.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-lt/27-Thunderbird-LT-15-22.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-lt/27-Thunderbird-LT-15-31.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-lt/27-Thunderbird-LT-15-7.jpg',
                    'product_id' => $idCreated
                ],
                [
                    'title' => 'title4',
                    'featured' => false,
                    'path' => 'thunderbird-lt/27-Thunderbird-LT-15-8.jpg',
                    'product_id' => $idCreated
                ],
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
      if (!is_null(self::$connection))
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
   * Execute a select on the Database will RETURN only one user on array[result]: 
   * <p><code>select * from shopping.user as u where (u.username=$usernameOrEmail or u.email=$usernameOrEmail and u.password=$password limit 1</code></p>
   * @return array ['result'=>array,'hasError'=>string]
   */
  public function getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail) {
    $hasError = '';
    $sql = "select * from shopping.user as u where (u.username=" . $this->quote($usernameOrEmail) . " or u.email=" . $this->quote($usernameOrEmail) . ") and u.password=" . $this->quote($password) . " limit 1";
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $hasError = $this->error();
    if (empty($result) && $hasError === '') {
      $hasError = "Invalid Username or Password";
    } else {
      // IF NO ERRORS RETURN SINGLE USER, NOT AN ARRAY OF USERS
      $result = $result[0];
    }
    $return = ['result' => $result, 'hasError' => $hasError];
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

  public function getProductById($idProduct, $withImages = false) {
    $sql = 'select * from shopping.product where id=' . $idProduct . ' limit 1';
    var_dump($sql);
    $result = $this->executeSQL($sql);
    $hasError = $this->error();
    if (empty($result) && $hasError === '') {
      $hasError = "Invalid ID. The Product ID does not exist.";
    } else {
      // IF NO ERRORS RETURN SINGLE USER, NOT AN ARRAY OF PRODUCTS
      $result = $result[0];
      if ($withImages === true) {
        $imagesReturn = $this->getProductImages($idProduct);
        if ($imagesReturn['hasError'] !== '') {
          $hasError = $imagesReturn['hasErrors'];
        } else {
          $images = $imagesReturn['result'];
          $result['images'] = $images;
        }
      }
    }
    $return = ['result' => $result, 'hasError' => $hasError];
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

}
