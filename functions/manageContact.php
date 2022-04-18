<?php
  session_start();
  include_once('../includes/connect.php');
  include_once('../includes/contact.php');

  if(!(isset($_SESSION) && $_SESSION['user_id'])){
      header('Location: ../login/index.php');
      die();
  }

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $mode = $_POST['mode'];
    $id = $_SESSION['user_id'];

    $conn = new Database();
    $conn = $conn->connect();

    $contact = new contact($conn);

    if($mode == "add") {
      if($contact->create($id, $fname, $lname, $email, $phone, $address)) {
        echo "success";
      } else {
        echo "error";
      }
     } else if($mode == "update") {
      $id = $_POST['id'];
      echo $contact->update($id, $fname, $lname, $email, $phone, $address, $id);
    }
  }

?>