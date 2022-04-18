<?php
  // a class to insert a new user to the database
  class User {
    private $first_name;
    private $last_name;
    private $email;
    private $password;

    public function __construct($first_name, $last_name, $email, $password) {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      $this->password = $password;
    }

    public function insert($conn) {
      $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:fname, :lname, :email, :password)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':fname', $this->first_name);
      $stmt->bindParam(':lname', $this->last_name);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);
      $stmt->execute();
    }
  }

  

?>