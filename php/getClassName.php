<?php 
  session_start();

  include('sqlConnect.php');

  $classID = $_GET["classID"];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT Name FROM Classes WHERE ID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $result = $sql->get_result();
  $row = $result->fetch_assoc();

  echo '<div class="info"><h1>'.$row["Name"].'</h1></div>';

  $conn->close();
?>
