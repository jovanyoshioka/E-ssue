<?php
  // Info used to log in and access data from database; including: name of the server, login username and password for access, and database name
  $servername = "localhost";
  $username = "root";
  $password = "password";
  $db = "essue";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $db);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>
