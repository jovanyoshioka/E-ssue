<?php 
  session_start();

  include('sqlConnect.php');

  $name = $_POST['studentName'];
  $grade = $_POST['grade'];
  $classGrade = $_POST['classGrade'];
  $redemptionCode = $_POST['redemptionCode']; // don't use this, but need it for dragging between notAssigned/assigned containers -- form won't submit if don't have field either.

  $eBookID = $_GET['eBookID'];

  $classID = $_SESSION['classID'];

  // Edit student's grade and classGrade
  $sql = $conn->prepare("UPDATE ClassStudents SET Grade=?, ClassGrade=? WHERE ClassID=? AND StudentName=?");
  $sql->bind_param("iiis",$grade,$classGrade,$classID,$name);
  $sql->execute();

  header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);

  $conn->close();
?>
