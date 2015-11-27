<?php

namespace database;

class Database {

  protected static $connection;

  public function __construct() {
    $sql = file_get_contents('scripts/create_tables.sql', true);
    $r = $this->multiQuery($sql);
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
  public function query($query) {
    // Connect to the database
    $connection = $this->connect();
    // Query the database
    $result = $connection->query($query);
    $this->closeConnection();
    return $result;
  }

  /**
   * Query the database
   *
   * @param $query The query string
   * @return mixed The result of the mysqli::query() function
   */
  public function multiQuery($query) {
    // Connect to the database
    /* @var $connection \mysqli */
    $connection = $this->connect();
    // Query the database
    $result = $connection->multi_query($query);
    $this->closeConnection();
    return $result;
  }

  /**
   * Fetch rows from the database (SELECT query)
   *
   * @param $query The query string
   * @return bool False on failure / array Database rows on success
   */
  public function select($query) {
    $rows = array();
    $result = $this->query($query);
    if ($result === false) {
      return false;
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

}
