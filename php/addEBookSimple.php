<?php
  session_start();

  include('sqlConnect.php');

  $eBookName = $_POST['name'];
  $eBookDescription = $_POST['description'];

  $classID = $_SESSION['classID'];

  // Add e-book to database
  $sql = $conn->prepare("INSERT INTO EBooks (Name,Description,ClassID) VALUES (?,?,?);");
  $sql->bind_param("ssi",$eBookName,$eBookDescription,$classID);
  $sql->execute();

  // Get ID of Ebook
  $sql = $conn->prepare("SELECT ID FROM EBooks WHERE Name=? AND ClassID=?");
  $sql->bind_param("si",$eBookName,$classID);

  $sql->execute();
  $result = $sql->get_result();
  $result = $result->fetch_assoc();

  $eBookID = $result["ID"];

  header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);

  $conn->close();
?>
