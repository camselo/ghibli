<?php

class Database {

  private $host = "localhost";
  private $database_name = "Ghibli";
  private $username = "root";
  private $password = "";

  public $conn;

  public function __construct() {
      $this->conn = null;
  }

  public function getConnection() {
    if($this->conn != null) {
        return $this->conn;
    }

    try {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->exec("set names utf8");
    } catch(PDOException $exception) {
        echo "Something went wrong while connecting to database.";
    }

    return $this->conn;
  }
}

?>