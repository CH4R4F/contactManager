<?php

  session_start();

  if(!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
  } 

  include "../includes/connect.php";
  include "../includes/contact.php";
  $conn = new Database();
  $conn = $conn->connect();

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $contact = new contact($conn);
    echo $contact->deleteContact($user_id, $id);
  }
?>