<?php
  session_start();
  include "../includes/connect.php";
  include "../includes/userData.php";

  $id = $_SESSION['user_id'];

  $conn = new Database();
  $conn = $conn->connect();
  $userContact = new UserData($conn, $id);

  echo json_encode($userContact->getContacts());
?>