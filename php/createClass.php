<?php 
  session_start();

  include('sqlConnect.php');

  $className = $_POST["className"];
  $teacherCode = $_SESSION["teacherCode"];

  // Add class to database
  $sql = $conn->prepare("INSERT INTO Classes (Name,TeacherID) VALUES (?,?);");
  $sql->bind_param("si",$className,$teacherCode);
  $sql->execute();

  $sql = $conn->prepare("SELECT ID FROM Classes WHERE Name=? AND TeacherID=?");
  $sql->bind_param("si",$className,$teacherCode);

  $sql->execute();
  $result = $sql->get_result();
  $result = $result->fetch_assoc();

  $classID = $result["ID"];

  header('Location: ../pages/class.php?classID='.$classID);

  $conn->close();
?>
