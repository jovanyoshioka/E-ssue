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

  // issue students selected the e-book
  if(!empty($_POST['students'])) {
    foreach($_POST['students'] as $selected) {
      $rCodeSuccess = false;

      while (!$rCodeSuccess) {
        // generate redemption code for student
        $redemptionCode = rand(100000000, 999999999);

        // check if redemptionCode already exists
        $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE RedemptionCode=?");
        $sql->bind_param("i",$redemptionCode);

        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows == 0) { // redemption code not existant, else, loop again
          $rCodeSuccess = true;
        }
      }

      // Add e-book to student
      $sql = $conn->prepare("INSERT INTO EBooksStudents (StudentName,ClassID,RedemptionCode,EBookID) VALUES (?,?,?,?);");
      $sql->bind_param("siii",$selected,$classID,$redemptionCode,$eBookID);
      $sql->execute();
    }
  }

  header('Location: ../pages/class.php?classID='.$classID);

  $conn->close();
?>
