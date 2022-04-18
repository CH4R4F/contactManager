<?php

  class UserData {
    private $user_id;
    private $user_first_name;
    private $user_last_name;
    private $user_email;
    private $user_password;
    private $user_profile_image;

    public function __construct($conn, $id) {
      $this->conn = $conn;
      $this->user_id = $id;
    }

    function getData() {
      $sql = "SELECT * FROM users WHERE user_id = :user_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!$result) {
        return false;
      }

      $this->user_id = $result['user_id'];
      $this->user_first_name = $result['first_name'];
      $this->user_last_name = $result['last_name'];
      $this->user_email = $result['email'];
      $this->user_password = $result['password'];
      $this->user_profile_image = $result['user_img'];
      $this->signup_date = $result['signup_date'];
      return true;
    }

    function getContacts() {
      $sql = "SELECT * FROM contacts WHERE user_id = :user_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      $result = $stmt->fetchAll();
      if(!$result) {
        return false;
      }
      return $result;
    }

    function getContactsCount() {
      if(!$this->getContacts()) {
        return 0;
      }
      return count($this->getContacts());
    }

    function getUserId() {
      return $this->user_id;
    }
    function getUserFirstName() {
      return $this->user_first_name;
    }
    function getUserLastName() {
      return $this->user_last_name;
    }
    function getUserEmail() {
      return $this->user_email;
    }
    function getUserPassword() {
      return $this->user_password;
    }
    function getUserProfileImage() {
      return $this->user_profile_image;
    }
    function getUserSignupDate() {
      return $this->signup_date;
    }
  }

?>