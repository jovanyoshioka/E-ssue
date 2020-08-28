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

  $rCodeSuccess = false;

  while (!$rCodeSuccess) {
    // generate redemption code for student
    $redemptionCode = rand(100000000, 999999999);

    // check if redemptionCode already exists
    $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE RedemptionCode=?");
    $sql->bind_param("i",$redemptionCode);

    $sql->execute();
    $results = $sql->get_result();

    if ($results->num_rows == 0) { // redemption code not existant, else, loop again
      $rCodeSuccess = true;
    }
  }

  // Add e-book to student
  $sql = $conn->prepare("INSERT INTO EBooksStudents (StudentName,ClassID,RedemptionCode,EBookID) VALUES (?,?,?,?);");
  $sql->bind_param("siii",$studentName,$classID,$redemptionCode,$eBookID);
  $sql->execute();
  
  header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);

  $conn->close();
?>
