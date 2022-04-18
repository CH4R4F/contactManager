<?php

  // a class to connect to the databse using PDO
  class Database {
    private $host = "localhost:3307";
    private $user = "cmarghin";
    private $password = "Cmarghindev02";
    private $database = "contactManager";

    public function connect() {
      try {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }
  }
