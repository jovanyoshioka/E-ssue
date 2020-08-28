<?php
  session_start();

  include('sqlConnect.php');

  $name = $_POST["studentName"];
  $grade = $_POST["grade"];
  $classGrade = $_POST["classGrade"];

  $classID = $_SESSION["classID"];

  // Add student to database
  $sql = $conn->prepare("INSERT INTO ClassStudents (StudentName,ClassID,Grade,ClassGrade) VALUES (?,?,?,?);");
  $sql->bind_param("siii",$name,$classID,$grade,$classGrade);
  $sql->execute();

  header('Location: ../pages/class.php?classID='.$classID);

  $conn->close();
?>
