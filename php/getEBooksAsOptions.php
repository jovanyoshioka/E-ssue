<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_GET['classID'];

  $sql = $conn->prepare("SELECT ID,Name,Description FROM EBooks WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $result = $sql->get_result();

  while ($row = $result->fetch_assoc()) {
    $id = $row["ID"];
    $name = $row["Name"];
    $desc = $row["Description"];

    if (isset($_GET['eBookID']) && $_GET['eBookID'] == $id) {
      $eBooksAsOptions .=
      '
        <option value="'.$id.'" selected>'.$name.' - '.$desc.'</option>
      ';
    } else {
      $eBooksAsOptions .=
      '
        <option value="'.$id.'">'.$name.' - '.$desc.'</option>
      ';
    }
  }

  echo $eBooksAsOptions;
?>
