<?php 
session_start();

// redirect if there is no session
  if(!(isset($_SESSION) && $_SESSION['user_id'])){
      header('Location: ../login/index.php');
      die();
  }

  // destroy the session
  unset($_SESSION);
  session_destroy();
  // redirect to the login page
  header("Location: ../login/index.php");
  die();

?>