<?php

  session_start();
  if(!(isset($_SESSION) && $_SESSION['user_id'])){
      header('Location: ../login/index.php');
      die();
  }

  include "../includes/connect.php";

  $conn = new Database();
  $conn = $conn->connect();
  if(isset($_GET['id'])) {
    $query = "SELECT * FROM contacts WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($contact);
  }

?>