<?php
  session_start();

  include('sqlConnect.php');

  $name = $_POST["studentName"];
  $grade = $_POST["grade"];
  $classGrade = $_POST["classGrade"];

  $classID = $_SESSION["classID"];

  // Edit student's grade and classGrade
  $sql = $conn->prepare("UPDATE ClassStudents SET Grade=?, ClassGrade=? WHERE ClassID=? AND StudentName=?");
  $sql->bind_param("iiis",$grade,$classGrade,$classID,$name);
  $sql->execute();

  if(!empty($_POST['eBooks'])) {
    foreach($_POST['eBooks'] as $selected) {
      $sql = $conn->prepare("SELECT ID FROM EBooks WHERE Name=? AND ClassID=?");
      $sql->bind_param("si",$selected,$classID);

      $sql->execute();
      $result = $sql->get_result();
      $row = $result->fetch_assoc();

      $eBookID = $row['ID'];

      if ($result->num_rows > 0) {
        $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE EBookID=? AND StudentName=? AND ClassID=?");
        $sql->bind_param("isi",$eBookID,$name,$classID);

        $sql->execute();
        $results = $sql->get_result();

        $rCodeSuccess = false;

        if ($results->num_rows == 0) {
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
          // Add user ebook to data
          $sql = $conn->prepare("INSERT INTO EBooksStudents (StudentName,ClassID,RedemptionCode,EBookID) VALUES (?,?,?,?);");
          $sql->bind_param("siii",$name,$classID,$redemptionCode,$eBookID);
          $sql->execute();
        }
      }
    }
  }

  // Remove E-book from student if not found selected
  $eBooksToRemove = array();

  $sql = $conn->prepare("SELECT ID FROM EBooks WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $allResults = $sql->get_result();

  while ($aRow = $allResults->fetch_assoc()) {
    array_push($eBooksToRemove, $aRow['ID']);
  }

  foreach($_POST['eBooks'] as $eBookSelected) {
    $sql = $conn->prepare("SELECT ID FROM EBooks WHERE Name=? AND ClassID=?");
    $sql->bind_param("si",$eBookSelected,$classID);

    $sql->execute();
    $theResults = $sql->get_result();
    $theRow = $theResults->fetch_assoc();

    $eBookID = $theRow['ID'];

    $eBooksToRemove = array_diff($eBooksToRemove,array($eBookID));
  }

  for ($i = 0; $i < count($eBooksToRemove); $i++) {
    $sql = $conn->prepare("DELETE FROM EBooksStudents WHERE StudentName=? AND ClassID=? AND EBookID=?");
    $sql->bind_param("sii",$name,$classID,$eBooksToRemove[$i]);
    $sql->execute();
  }

  header('Location: ../pages/class.php?classID='.$classID);

  $conn->close();
?>
