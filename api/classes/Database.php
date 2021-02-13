<?php

class Database {

  private $host = 'br850.hostgator.com.br';
  private $database_name = 'brainy29_ghibli';
  private $username = 'brainy29_lele';
  private $password = 'saranghae123';

  public $conn;

  public function getConnection() {
    try {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->exec("set names utf8");
        return $this->conn;
    } catch(PDOException $exception) {
        $this->conn = null;
        echo "Something went wrong while connecting to database.". $exception;
    }

  }
}

?>