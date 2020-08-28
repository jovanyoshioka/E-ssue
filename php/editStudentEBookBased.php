<?php
  session_start();

  include('sqlConnect.php');

  $name = $_POST['studentName'];
  $grade = $_POST['grade'];
  $classGrade = $_POST['classGrade'];
  $redemptionCode = $_POST['redemptionCode'];

  $eBookID = $_GET['eBookID'];

  $classID = $_SESSION['classID'];

  // Edit student's grade and classGrade
  $sql = $conn->prepare("UPDATE ClassStudents SET Grade=?, ClassGrade=? WHERE ClassID=? AND StudentName=?");
  $sql->bind_param("iiis",$grade,$classGrade,$classID,$name);
  $sql->execute();

  $same = false;

  // check if redemptionCode posted is same one as current --> not changed
  $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE RedemptionCode=? AND StudentName=? AND ClassID=? AND EBookID=?");
  $sql->bind_param("isii",$redemptionCode,$name,$classID,$eBookID);
  $sql->execute();
  $results = $sql->get_result();

  if ($results->num_rows > 0)
    $same = true;

  // check if redemptionCode already exists
  $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE RedemptionCode=?");
  $sql->bind_param("i",$redemptionCode);

  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows == 0) { // redemption code not existant, else, loop again
    // update redemption code
    $sql = $conn->prepare("UPDATE EBooksStudents SET RedemptionCode=? WHERE ClassID=? AND StudentName=? AND EBookID=?");
    $sql->bind_param("iisi",$redemptionCode,$classID,$name,$eBookID);
    $sql->execute();

    header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);
  } else if ($same) {
    header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID);
  } else {
    header('Location: ../pages/class.php?classID='.$classID.'&eBookID='.$eBookID.'&error=1');
  }

  $conn->close();
?>
