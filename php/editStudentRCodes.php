<?php
  session_start();

  include('sqlConnect.php');

  $name = $_POST["studentName"];
  $classID = $_SESSION["classID"];

  $originalRCodes = $_POST['OriginalRedemptionCodes'];
  $newRCodes = $_POST['NewRedemptionCodes'];

  foreach($originalRCodes as $key => $selected) {
    if ($newRCodes[$key] != "" && $newRCodes[$key] != $selected) {
      // check if redemptionCode already exists
      $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE RedemptionCode=?");
      $sql->bind_param("i",$newRCodes[$key]);

      $sql->execute();
      $result = $sql->get_result();

      if ($result->num_rows == 0) { // redemption code not existant so change it
        // get ID of ebook
        $sql = $conn->prepare("SELECT EBookID FROM EBooksStudents WHERE RedemptionCode=?");
        $sql->bind_param("i",$selected);

        $sql->execute();
        $results = $sql->get_result();
        $row = $results->fetch_assoc();

        $eBookID = $row["EBookID"];

        $sql = $conn->prepare("UPDATE EBooksStudents SET RedemptionCode=? WHERE classID=? AND StudentName=? AND EBookID=?");
        $sql->bind_param("iisi",$newRCodes[$key],$classID,$name,$eBookID);
        $sql->execute();
      }
      else {
        $error = true;
      }
    }
  }

  if ($error)
    header('Location: ../pages/class.php?classID='.$classID.'&error=1');
  else
    header('Location: ../pages/class.php?classID='.$classID);

  $conn->close();
?>
