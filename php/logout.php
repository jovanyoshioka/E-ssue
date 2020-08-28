<?php
  // Start session
  session_start();

  // Set all session variables to null and destroy session
  $_SESSION = array();
  session_destroy();

  // Redirect to home page
  header("Location: ../pages/home.php");
  exit();
?>
