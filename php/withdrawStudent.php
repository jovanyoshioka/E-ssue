<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_GET['classID'];
  $eBookID = $_GET['eBookID'];
  $studentID = str_replace('studentID_', '', $_GET['studentID']);

  $sql = $conn->prepare("SELECT StudentName FROM ClassStudents WHERE ClassID=? AND ID=?");
  $sql->bind_param("ii",$classID,$studentID);
  $sql->execute();

  $result = $sql->get_result();
  $row = $result->fetch_assoc();

  $studentName = $row['StudentName'];

  $sql = $conn->prepare("DELETE FROM EBooksStudents WHERE StudentName=? AND ClassID=? AND EBookID=?");
  $sql->bind_param("sii",$studentName,$classID,$eBookID);
  $sql->execute();

  header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);

  $conn->close();
?>
