<?php

  // a class that handles the authentication of the user
  class Auth {
    private $conn;
    private $user;
    private $password;

    public function __construct($conn, $email, $password) {
      $this->conn = $conn;
      $this->email = $email;
      $this->password = $password;
    }

    public function login() {
      $sql = "SELECT * FROM users WHERE email = :email";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':email', $this->email);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result) {
        if($this->password == $result['password']) {
          $_SESSION['user_name'] = $result['first_name'] . " " . $result['last_name'];
          $_SESSION['user_id'] = $result['user_id'];
          $_SESSION['login_date'] = date('Y-m-d H:i:s');
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    public function logout() {
      unset($_SESSION['user']);
      unset($_SESSION['user_id']);
      session_destroy();
    }
  }

?>