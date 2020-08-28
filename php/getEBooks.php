<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_SESSION['classID'];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT ID,Name,Description FROM EBooks WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $result = $sql->get_result();

  $i = 0;

  while ($row = $result->fetch_assoc()) {
    $id = $row["ID"];
    $name = $row["Name"];
    $description = $row["Description"];

    // Display all students that have the same Ebook ID
    $sql = $conn->prepare("SELECT StudentName,RedemptionCode FROM EBooksStudents WHERE ClassID=? AND EBookID=?");
    $sql->bind_param("ii",$classID,$id);
    $sql->execute();

    $results = $sql->get_result();

    while ($rows = $results->fetch_assoc()) {
      $students .= $rows["StudentName"].' - Redemption Code: '.$rows["RedemptionCode"].'<br>';
    }

    $listOfEBooks .=
    '
      <tr>
        <td>'.$name.'</td>
        <td>'.$description.'</td>
        <td>
          <button onclick="openModal(\'viewEBook-modal-'.$i.'\', \'viewEBook-modal-overlay-'.$i.'\')">View</button>
          <div class="modal-overlay simple-modal-overlay" id="viewEBook-modal-overlay-'.$i.'" onclick="closeModal(\'viewEBook-modal-'.$i.'\', \'viewEBook-modal-overlay-'.$i.'\')"></div>
          <div class="modal simple-modal" id="viewEBook-modal-'.$i.'">
            <header>'.$name.'<i class="fas fa-times" onclick="closeModal(\'viewEBook-modal-'.$i.'\', \'viewEBook-modal-overlay-'.$i.'\')"></i></header>
            <section>
              '.$students.'
            </section>
          </div>
        </td>
      </tr>
    ';

    $i++;

    $students = "";
  }
?>
