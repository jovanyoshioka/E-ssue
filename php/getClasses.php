<?php
  session_start();

  include('sqlConnect.php');

  $teacherCode = $_SESSION['teacherCode'];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT ID,Name FROM Classes WHERE TeacherID=?");
  $sql->bind_param("i",$teacherCode);
  $sql->execute();

  $result = $sql->get_result();

  while ($row = $result->fetch_assoc()) {
    $classID = $row["ID"];
    $className = $row["Name"];

    $classes .=
    '
      <a href="../pages/class.php?classID='.$classID.'">'.$className.'</a>
    ';
  }
?>
