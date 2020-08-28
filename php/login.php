<?php
  include("../php/sqlConnect.php");

  // Get given email from database
  $email = $_POST["email"];

  $sql = $conn->prepare("SELECT ID FROM Users WHERE Email=?");
  $sql->bind_param("s",$email);

  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows == 0) {
    $noEmail = true;
  } else {
    $sql = $conn->prepare("SELECT ID,Password,FirstName,LastName,TeacherCode FROM Users WHERE Email=?");
    $sql->bind_param("s",$email);

    $sql->execute();
    $result = $sql->get_result();
    $result = $result->fetch_assoc();

    $id = $result["ID"];
    $password = $result["Password"];
    $firstname = $result["FirstName"];
    $lastname = $result["LastName"];
    $teacherCode = $result["TeacherCode"];

    $conn->close();

    // Check if passwords match
    if (password_verify($_POST["password"], $password) == 1) {
      // Set session variables to keep user logged in and so we don't need to pull from the database so often
      $_SESSION["id"] = $id;
      $_SESSION["email"] = $email;
      $_SESSION["firstName"] = $firstname;
      $_SESSION["lastName"] = $lastname;
      $_SESSION["teacherCode"] = $teacherCode;
    } else {
      $noPass = true;
    }
  }
?>
