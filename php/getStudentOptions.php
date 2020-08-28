<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_SESSION['classID'];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT StudentName FROM ClassStudents WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $result = $sql->get_result();

  while ($row = $result->fetch_assoc()) {
    $name = $row["StudentName"];

    $studentsOptions .=
    '
      '.$name.' <input type="checkbox" name="students[]" value="'.$name.'"><br>
    ';
  }
?>
