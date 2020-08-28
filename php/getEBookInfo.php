<?php
  session_start();

  include('sqlConnect.php');

  $classID = $_GET['classID'];
  $eBookID = $_GET['eBookID'];

  $sql = $conn->prepare("SELECT ID,StudentName,Grade,ClassGrade FROM ClassStudents WHERE ClassID=?");
  $sql->bind_param("i",$classID);
  $sql->execute();

  $results = $sql->get_result();

  $notAssignedStudents = "";
  $assignedStudents = "";

  while ($row = $results->fetch_assoc()) {
    $studentID = $row['ID'];
    $studentName = $row['StudentName'];
    $grade = $row['Grade'];
    $classGrade = $row['ClassGrade'];

    $sql = $conn->prepare("SELECT RedemptionCode FROM EBooksStudents WHERE ClassID=? AND EBookID=? AND StudentName=?");
    $sql->bind_param("iis",$classID,$eBookID,$studentName);
    $sql->execute();

    $result = $sql->get_result();
    $theRow = $result->fetch_assoc();

    if ($result->num_rows > 0) {
      $redemptionCode = $theRow['RedemptionCode'];

      $assignedStudents .=
      '
        <div draggable="true" ondragstart="drag(this.id)" class="draggableStudent" id="studentID_'.$studentID.'">
          <form role="form" action="../php/editStudentEBookBased.php?eBookID='.$eBookID.'" method="POST">
            <input type="text" class="dragAndDrop-studentName" name="studentName" value="'.$studentName.'" readonly>
            <input type="text" name="grade" value="'.$grade.'" required>
            <input type="text" name="classGrade" value="'.$classGrade.'" required>
            <input type="text" class="dragAndDrop-redemptionCode" name="redemptionCode" value="'.$redemptionCode.'" required>
            <button type="submit" value="Submit">Save</button>
          </form>
        </div>
      ';
    } else {
      $notAssignedStudents .=
      '
        <div draggable="true" ondragstart="drag(this.id)" class="draggableStudent" id="studentID_'.$studentID.'">
          <form role="form" action="../php/editStudentInfo.php?eBookID='.$eBookID.'" method="POST">
            <input type="text" class="dragAndDrop-studentName" name="studentName" value="'.$studentName.'" readonly>
            <input type="text" name="grade" value="'.$grade.'" required>
            <input type="text" name="classGrade" value="'.$classGrade.'" required>
            <input type="text" class="dragAndDrop-redemptionCode" name="redemptionCode" value="null" required>
            <button type="submit" value="Submit">Save</button>
          </form>
        </div>
      ';
    }
  }

  $interface =
  '
    <div id="notAssigned-container">
      <header>Students Not Issued<h2>Student Name - Grade - Class Grade</h2></header>
      '.$notAssignedStudents.'
      <div ondrop="unassign(event, '.$classID.')" ondragover="allowDrop(event)" id="notAssigned-droppable"><img src="../media/plusIcon.png" /></div>
    </div>
    <div id="assigned-container">
      <header>Students Issued<h2>Student Name - Grade - Class Grade - Redemption Code</h2></header>
      '.$assignedStudents.'
      <div ondrop="assign(event, '.$classID.')" ondragover="allowDrop(event)" id="assigned-droppable"><img src="../media/plusIcon.png" /></div>
    </div>
  ';

  echo $interface;
?>
