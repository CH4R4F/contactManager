<?php

  // class crud for contacts
  class contact {

    // object properties
    private $id;
    private $fname;
    private $lname;
    private $email;
    private $phone;
    private $address;

    // constructor with $db as database connection
    public function __construct($db){
      $this->conn = $db;
    }

    // read contacts
    function read(){
      // select all query
      $query = "SELECT
                id, name, email, phone, address, created
                FROM
                contacts";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
    }

    // create contact
    function create($id, $fname, $lname, $email, $phone, $address){
      // query to insert record
      $query = "INSERT INTO
                contacts
                SET
                fname=:fname, lname=:lname, email=:email, phone=:phone, address=:address, image=:image, user_id=:user_id";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->fname = htmlspecialchars(strip_tags($fname));
      $this->lname = htmlspecialchars(strip_tags($lname));
      $this->email = htmlspecialchars(strip_tags($email));
      $this->phone = htmlspecialchars(strip_tags($phone));
      $this->address = htmlspecialchars(strip_tags($address));
      
      // random image between 1 - 5 (hadchi li 3ta lah)
      $this->image = "avatar-".rand(1,5).".png";
      // bind values
      $stmt->bindParam(":fname", $this->fname);
      $stmt->bindParam(":lname", $this->lname);
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":phone", $this->phone);
      $stmt->bindParam(":address", $this->address);
      $stmt->bindParam(":image", $this->image);
      $stmt->bindParam(":user_id", $id);
      // execute
      if($stmt->execute()){
        return true;
      }
    }

    public function deleteContact($user_id, $id) {
      $query = "DELETE FROM contacts WHERE user_id = :user_id AND id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":user_id", $user_id);
      $stmt->bindParam(":id", $id);
      if($stmt->execute()) {
        return 'success';
      }
      return 'error';
    }

    public function update($id, $fname, $lname, $email, $phone, $address) {
      $query = "UPDATE contacts SET fname = :fname, lname = :lname, email = :email, phone = :phone, address = :address WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":fname", $fname);
      $stmt->bindParam(":lname", $lname);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":address", $address);
      $stmt->bindParam(":id", $id);
      if($stmt->execute()) {
        return 'success';
      }
      return 'error';
    }

    public function getContactById($id) {
      $query = "SELECT * FROM contacts WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      return $stmt;
    }
  }

?>