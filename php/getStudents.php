<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_SESSION['classID'];

  // Check if account with same email is already existant
  $sql = $conn->prepare("SELECT StudentName,Grade,ClassGrade FROM ClassStudents WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $result = $sql->get_result();

  $i = 0;

  while ($row = $result->fetch_assoc()) {
    $name = $row["StudentName"];

    $_SESSION['currentStudent'] = $name;

    // Get options of which e-books to assign student
    include('getEBookOptions.php');

    include('getRCodesOptions.php');

    $grade = $row["Grade"];
    $classGrade = $row["ClassGrade"];
    $name = $row["StudentName"];

    $students .=
    '
      <tr class="tableStudentsRows">
        <td class="tableStudentRow-Name">'.$name.'</td>
        <td>'.$grade.'</td>
        <td>
          <button onclick="openModal(\'viewEditStudent-modal-'.$i.'\', \'viewEditStudent-modal-overlay-'.$i.'\')">View/Edit</button>
          <div class="modal-overlay simple-modal-overlay" id="viewEditStudent-modal-overlay-'.$i.'" onclick="closeModal(\'viewEditStudent-modal-'.$i.'\', \'viewEditStudent-modal-overlay-'.$i.'\')"></div>
          <div class="modal simple-modal" id="viewEditStudent-modal-'.$i.'">
            <header>View/Edit a Student<i class="fas fa-times" onclick="closeModal(\'viewEditStudent-modal-'.$i.'\', \'viewEditStudent-modal-overlay-'.$i.'\')"></i></header>
            <section>
              <form role="form" action="../php/editStudent.php" method="POST">
                Student Name<br>
                <input type="text" name="studentName" value="'.$name.'" readonly><br>
                Grade<br>
                <input type="text" name="grade" value="'.$grade.'" required><br>
                Class Grade<br>
                <input type="text" name="classGrade" value="'.$classGrade.'" required><br>
                Issue an E-book:<br>
                '.$eBookOptions.'
                <input type="submit" value="Save">
              </form>
            </section>
          </div>

          <button onclick="openModal(\'redemptionCodesStudent-modal-'.$i.'\', \'redemptionCodesStudent-modal-overlay-'.$i.'\')">Redemption Codes</button>
          <div class="modal-overlay simple-modal-overlay" id="redemptionCodesStudent-modal-overlay-'.$i.'" onclick="closeModal(\'redemptionCodesStudent-modal-'.$i.'\', \'redemptionCodesStudent-modal-overlay-'.$i.'\')"></div>
          <div class="modal simple-modal" id="redemptionCodesStudent-modal-'.$i.'">
            <header>View/Edit Redemption Codes<i class="fas fa-times" onclick="closeModal(\'redemptionCodesStudent-modal-'.$i.'\', \'redemptionCodesStudent-modal-overlay-'.$i.'\')"></i></header>
            <section>
              <form role="form" action="../php/editStudentRCodes.php" method="POST">
                Student Name<br>
                <input type="text" name="studentName" value="'.$name.'" readonly><br>
                Redemption Codes:<br>
                '.$redemptionCodesOptions.'
                <input type="submit" value="Save">
              </form>
            </section>
          </div>
        </td>
      </tr>
    ';

    $redemptionCodesOptions = "";
    $eBookOptions = "";
    $i++;
  }
?>
