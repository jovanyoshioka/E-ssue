<?php
  session_start();

  $_SESSION["classID"] = $_GET["classID"];

  if ($_GET["error"] == 1)
  {
    echo '
      <div id="errorNotification" class="errorNotification">
      	<div class="errorNotification-message">
      		<h1>An error has occurred.</h1>
      		<p>Inputted Redemption Code already exists! Please try another.</p>
      	</div>
      	<div class="errorNotification-button">
      		<i class="fas fa-times" onclick="closeErrorNotification()"></i>
      	</div>
      </div>
    ';
  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>E-ssue</title>
		<?php
			$page = 'class';
			include('../php/head.php');
		?>
	</head>
	<body id="class">
    <?php include('../php/getClassName.php'); ?>

    <?php include('../php/navbar.php'); ?>

    <br>
    <div id="classOptions">
      <h1 id="viewInterface">Interface Selection:</h1>
	    <button id="viewModalsInterface" onclick="setInterface('modalsInterface')" onmouseover="setInterfaceHover('viewModalsInterface','#C2C2C2')" onmouseout="setInterfaceHover('viewModalsInterface','buttonface')">Tables & Modals</button>
	    <button id="viewDragAndDropInterface" onclick="setInterface('dragAndDropInterface')" onmouseover="setInterfaceHover('viewDragAndDropInterface','#C2C2C2')" onmouseout="setInterfaceHover('viewDragAndDropInterface','buttonface')">Drag & Drop</button>
        <a href="weeklyReport.php?classID=<?php echo $_GET["classID"]; ?>"><button id="viewWeeklyReportBtn">View Weekly Report</button></a><br>
    </div>

    <div id="dragAndDropInterface">
      <select id="eBooksDropdown" onchange="getEBookInfo(<?php echo $_GET["classID"] ?>)">
        <?php
          if ((!(isset($_GET['eBookID']))) || ($_GET[eBookID] == ""))
            echo '<option value="null" disabled selected>Choose an E-book</option>';
          else
            echo '<option value="null" disabled>Choose an E-book</option>';
        ?>

        <?php include('../php/getEBooksAsOptions.php') ?>
      </select>

      <button id="dragAndDrop-AddEBook" onclick="openModal('simple-addEBook-modal', 'simple-addEBook-modal-overlay')">Add an E-book</button>
      <button id="dragAndDrop-AddStudent" onclick="openModal('simple-addStudent-modal', 'simple-addStudent-modal-overlay')">Add a Student</button>

      <input type="text" id="search" onkeyup="searchForStudent()" placeholder="Search for a student..." />

      <?php include('../php/getEBookInfo.php') ?>
    </div>

    <div id="modalsInterface">
      <br>
      <table>
        <tr>
          <th>E-books</th>
          <th>Description</th>
          <th></th>
        </tr>

        <?php
          include('../php/getEBooks.php');
          echo $listOfEBooks;
        ?>
      </table>

      <button id="addEBookBtn" onclick="openModal('addEBook-modal', 'addEBook-modal-overlay')">Add an E-book</button>
      <div class="modal-overlay simple-modal-overlay" id="addEBook-modal-overlay" onclick="closeModal('addEBook-modal', 'addEBook-modal-overlay')"></div>
  		<div class="modal simple-modal" id="addEBook-modal">
  			<header>Add an E-book<i class="fas fa-times" onclick="closeModal('addEBook-modal', 'addEBook-modal-overlay')"></i></header>
  			<section>
			    <form role="form" action="../php/addEBook.php" method="POST">
    				E-book Name<br>
    				<input type="text" name="name" required><br>
    				Description<br>
    				<input type="text" name="description" required><br>
    				Issue to Students:<br>
    			    <div id="studentsAsOptions">
  			        <?php
			            include('../php/getStudentOptions.php');
                  echo $studentsOptions;
  			        ?>
    			    </div>
    				<input type="submit" value="Add">
    			</form>
  			</section>
  		</div>

      <br>
      <input type="text" id="tableSearch" onkeyup="tableSearchForStudent()" placeholder="Search for a student..." />
      <table>
        <tr>
          <th>Student</th>
          <th>Grade</th>
          <th></th>
        </tr>
        <?php
          include('../php/getStudents.php');
          echo $students;
        ?>
      </table>

      <button id="addStudentBtn" onclick="openModal('addStudent-modal', 'addStudent-modal-overlay')">Add a Student</button>
      <div class="modal-overlay simple-modal-overlay" id="addStudent-modal-overlay" onclick="closeModal('addStudent-modal', 'addStudent-modal-overlay')"></div>
  		<div class="modal simple-modal" id="addStudent-modal">
  			<header>Add a Student<i class="fas fa-times" onclick="closeModal('addStudent-modal', 'addStudent-modal-overlay')"></i></header>
  			<section>
			    <form role="form" action="../php/addStudent.php" method="POST">
    				Student Name<br>
    				<input type="text" name="studentName" required><br>
    				Grade<br>
    				<input type="text" name="grade" required><br>
    				Class Grade<br>
    				<input type="text" name="classGrade" required><br>
    				<input type="submit" value="Add">
    			</form>
  			</section>
  		</div>
  	</div>

    <div class="modal-overlay simple-modal-overlay" id="simple-addEBook-modal-overlay" onclick="closeModal('simple-addEBook-modal', 'simple-addEBook-modal-overlay')"></div>
		<div class="modal simple-modal" id="simple-addEBook-modal">
			<header>Add an E-book<i class="fas fa-times" onclick="closeModal('simple-addEBook-modal', 'simple-addEBook-modal-overlay')"></i></header>
			<section>
		    <form role="form" action="../php/addEBookSimple.php" method="POST">
  				E-book Name<br>
  				<input type="text" name="name" required><br>
  				Description<br>
  				<input type="text" name="description" required><br>
  				<input type="submit" value="Add">
  			</form>
			</section>
		</div>

    <div class="modal-overlay simple-modal-overlay" id="simple-addStudent-modal-overlay" onclick="closeModal('simple-addStudent-modal', 'simple-addStudent-modal-overlay')"></div>
		<div class="modal simple-modal" id="simple-addStudent-modal">
			<header>Add a Student<i class="fas fa-times" onclick="closeModal('simple-addStudent-modal', 'simple-addStudent-modal-overlay')"></i></header>
			<section>
		    <form role="form" action="../php/addStudentSimple.php?eBookID=<?php echo $_GET['eBookID'] ?>" method="POST">
  				Student Name<br>
  				<input type="text" name="studentName" required><br>
  				Grade<br>
  				<input type="text" name="grade" required><br>
  				Class Grade<br>
  				<input type="text" name="classGrade" required><br>
  				<input type="submit" value="Add">
  			</form>
			</section>
		</div>

		<?php
      if (isset($_GET["eBookID"])) {
        echo '
          <script>setInterface("dragAndDropInterface")</script>
        ';
      } else {
        echo '
          <script>setInterface("modalsInterface")</script>
        ';
      }
	  ?>

	</body>
</html>
