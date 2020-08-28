<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_SESSION['classID'];
  $currentStudent = $_SESSION['currentStudent'];

  $sql = $conn->prepare("SELECT ID,Name FROM EBooks WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $resultsss = $sql->get_result();

  while ($rowss = $resultsss->fetch_assoc()) {
    $id = $rowss["ID"];
    $name = $rowss["Name"];

    // Get redemption codes from database
    $sql = $conn->prepare("SELECT RedemptionCode FROM EBooksStudents WHERE ClassID=? AND StudentName=? AND EBookID=?");
    $sql->bind_param("isi",$classID,$currentStudent,$id);
    $sql->execute();

    $resultssss = $sql->get_result();
    if ($resultssss->num_rows > 0) {
      $rowsss = $resultssss->fetch_assoc();

      $redemptionCode = $rowsss["RedemptionCode"];

      $redemptionCodesOptions .=
      '
        '.$name.'  <input type="text" name="OriginalRedemptionCodes[]" value="'.$redemptionCode.'" readonly> <br>change to <input type="text" name="NewRedemptionCodes[]"><br>
      ';
    }
  }
?>
