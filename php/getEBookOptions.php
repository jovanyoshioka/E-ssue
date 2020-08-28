<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_SESSION['classID'];
  $currentStudent = $_SESSION['currentStudent'];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT ID,Name FROM EBooks WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $results = $sql->get_result();

  while ($rows = $results->fetch_assoc()) {
    $id = $rows["ID"];
    $name = $rows["Name"];

    // Check if student already issued e-book, if so, check it
    $sql = $conn->prepare("SELECT ID FROM EBooksStudents WHERE ClassID=? AND StudentName=? AND EBookID=?");
    $sql->bind_param("isi",$classID,$currentStudent,$id);
    $sql->execute();

    $resultss = $sql->get_result();

    if ($resultss->num_rows > 0) {
      $eBookOptions .=
      '
        '.$name.' <input type="checkbox" name="eBooks[]" value="'.$name.'" checked><br>
      ';
    } else {
      $eBookOptions .=
      '
        '.$name.' <input type="checkbox" name="eBooks[]" value="'.$name.'"><br>
      ';
    }
  }
?>
